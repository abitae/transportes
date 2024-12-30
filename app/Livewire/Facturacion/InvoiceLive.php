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
        //dd($company);
        $sunat = new SunatService();
        //creo la configuracion see
        $see = $sunat->getSee($company);
        //dd($see);
        $invoce = $sunat->getInvoce($invoice);
        $xml = $see->getXmlSigned($invoce);
        $hash = (new XmlUtils())->getHashSign($xml);
        $invoice->xml_hash = $hash;
        $invoice->xml_path='xml/'.$invoice->company->ruc.'-'.$invoice->tipoDoc.'-'.$invoice->serie.'-'.$invoice->correlativo.'.xml';
        $invoice->save();
        Storage::disk('public')->put('xml/'.$invoice->company->ruc.'-'.$invoice->tipoDoc.'-'.$invoice->serie.'-'.$invoice->correlativo.'.xml', $xml);
        //return $xml;
    }
    public function xmlDownload(Invoice $invoice)
    {
        if(Storage::exists($invoice->xml_path))
        {
            return Storage::disk('public')->download($invoice->xml_path);
        }
        
    }
    public function sendXmlFile(Invoice $invoice)
    {
        $company = $invoice->company;
        $sunat = new SunatService();
        $see = $sunat->getSee($company);
        $xml = Storage::disk('public')->get($invoice->xml_path);
        $result = $see->sendXmlFile($xml);
        if ($result->isSuccess()) {
            $cdr = $result->getCdrResponse();
            $invoice->cdr_description = $cdr->getDescription();
            $invoice->cdr_code = $cdr->getCode();
            $invoice->cdr_note = $cdr->getNotes();
            $invoice->cdr_path = 'cdr/'.$invoice->company->ruc.'-'.$invoice->tipoDoc.'-'.$invoice->serie.'-'.$invoice->correlativo.'.zip';
            $invoice->save();
            Storage::disk('public')->put('cdr/'.$invoice->company->ruc.'-'.$invoice->tipoDoc.'-'.$invoice->serie.'-'.$invoice->correlativo.'.zip', $result->getCdrZip());
            $this->toast('success', 'Factura enviada a la sunat');
        } else {
            $this->toast('error', 'Error al enviar la factura a la sunat');
        }
    }
    public function downloadCdrFile(Invoice $invoice)
    {
        if(Storage::exists($invoice->cdr_path))
        {
            return Storage::disk('public')->download($invoice->cdr_path);
        }
    }

}
