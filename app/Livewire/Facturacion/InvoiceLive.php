<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Invoice;
use App\Services\SunatService;
use App\Services\SunatServiceGlobal;
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
    public string $title = 'Facturacion';
    public string $sub_title = 'Modulo de facturacion';
    public int $perPage = 10;

    public function render()
    {
        $invoices = Invoice::latest()->paginate($this->perPage);
        return view('livewire.facturacion.invoice-live', compact('invoices'));
    }

    public function xmlGenerate(Invoice $invoice)
    {
        $company = $invoice->company;
        $sunat = new SunatService();
        $see = $sunat->getSee($company);
        $invoce = $sunat->getInvoce($invoice);
        
        $xml = $see->getXmlSigned($invoce);
        $hash = (new XmlUtils())->getHashSign($xml);
        $invoice->xml_hash = $hash;
        $invoice->xml_path = 'xml/' . $invoice->company->ruc . '-' . $invoice->tipoDoc . '-' . $invoice->serie . '-' . $invoice->correlativo . '.xml';
        $invoice->save();
        Storage::disk('public')->put($invoice->xml_path, $xml);
    }

    public function xmlDownload(Invoice $invoice)
    {
        if (Storage::exists($invoice->xml_path)) {
            return response()->download(storage_path('app/public/' . $invoice->xml_path));
        }
    }

    public function sendXmlFile(Invoice $invoice)
    {
        $company = $invoice->company;
        $sunat = new SunatService();
        $see = $sunat->getSee($company);
        $xml = Storage::disk('public')->get($invoice->xml_path);
        $result = $see->sendXmlFile($xml);
        $response = $sunat->sunatResponse($result);

        if ($response['success']) {
            $invoice->cdr_description = $response['cdrResponse']['description'];
            $invoice->cdr_code = $response['cdrResponse']['code'];
            $invoice->cdr_note = $response['cdrResponse']['notes'];
            $invoice->cdr_path = 'cdr/' . 'R-' . $invoice->company->ruc . '-' . $invoice->tipoDoc . '-' . $invoice->serie . '-' . $invoice->correlativo . '.zip';
            $invoice->save();
            Storage::disk('public')->put($invoice->cdr_path, $response['cdrResponse']['cdrZip']);
            $this->toast('success', 'Factura enviada a la sunat');
        } else {
            $invoice->errorCode = $response['error']['code'];
            $invoice->errorMessage = $response['error']['message'];
            $this->toast('error', 'Error al enviar la factura a la sunat');
        }
    }

    public function downloadCdrFile(Invoice $invoice)
    {
        if (Storage::exists($invoice->cdr_path)) {
            return response()->download(storage_path('app/public/' . $invoice->cdr_path));
        }
    }
    public function refresh() {
        $prueba = new SunatServiceGlobal();
        $data = $prueba->getInvoce('F001-1');
        dd($data);
    }
}
