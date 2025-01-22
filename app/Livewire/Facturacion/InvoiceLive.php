<?php
namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Invoice;
use App\Services\SunatService;
use Greenter\Report\XmlUtils;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class InvoiceLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title     = 'Facturacion';
    public string $sub_title = 'Modulo de facturacion';
    public int $perPage      = 10;

    public function render()
    {
        $invoices = Invoice::latest()->paginate($this->perPage);
        return view('livewire.facturacion.invoice-live', compact('invoices'));
    }

    public function xmlGenerate(Invoice $invoice)
    {
        $company = $invoice->company;
        $sunat   = new SunatService();
        $see     = $sunat->getSee($company);
        $invoce  = $sunat->getInvoce($invoice);

        $xml               = $see->getXmlSigned($invoce);
        $hash              = (new XmlUtils())->getHashSign($xml);
        $invoice->xml_hash = $hash;
        $invoice->xml_path = $this->generateFilePath($invoice, 'xml');
        $invoice->save();
        Storage::disk('public')->put($invoice->xml_path, $xml);
    }

    public function xmlDownload(Invoice $invoice)
    {
        return $this->downloadFile($invoice->xml_path);
    }

    public function sendXmlFile(Invoice $invoice)
    {
        $company = $invoice->company;
        $sunat   = new SunatService();
        $see     = $sunat->getSee($company);

        if (! Storage::disk('public')->exists($invoice->xml_path)) {
            $this->toast('error', 'El archivo XML no existe');
            return;
        }
        if (!$invoice->xml_hash || !$invoice->xml_path) {
            $this->toast('error', 'El archivo XML no ha sido generado');
            return;
        }
        $xml      = Storage::disk('public')->get($invoice->xml_path);
        $result   = $see->sendXmlFile($xml);
        $response = $sunat->sunatResponse($result);

        if ($response['success']) {
            $invoice->cdr_description = $response['cdrResponse']['description'];
            $invoice->cdr_code        = $response['cdrResponse']['code'];
            $invoice->cdr_note        = $response['cdrResponse']['notes'];
            $invoice->cdr_path        = $this->generateFilePath($invoice, 'cdr', 'R-');
            $invoice->save();
            Storage::disk('public')->put($invoice->cdr_path, $response['cdrResponse']['cdrZip']);
            $this->toast('success', 'Factura enviada a la sunat');
        } else {
            $invoice->errorCode    = $response['error']['code'];
            $invoice->errorMessage = $response['error']['message'];
            $this->toast('error', 'Error al enviar la factura a la sunat');
        }
    }

    public function downloadCdrFile(Invoice $invoice)
    {
        return $this->downloadFile($invoice->cdr_path);
    }

    private function generateFilePath(Invoice $invoice, string $type, string $prefix = '')
    {
        return $type . '/' . $prefix . $invoice->company->ruc . '-' . $invoice->tipoDoc . '-' . $invoice->serie . '-' . $invoice->correlativo . '.xml';
    }

    private function downloadFile(string $path)
    {
        if (Storage::exists($path)) {
            return response()->download(storage_path('app/public/' . $path));
        }
    }
}
