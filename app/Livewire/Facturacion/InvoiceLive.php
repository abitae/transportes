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
    public function xml(Invoice $invoice)
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
        Storage::disk('public')->put('xml/example2.xml', $xml);
        return $xml;
    }
}
