<?php

namespace App\Livewire\Configuration;

use App\Livewire\Forms\CompanyForm;
use App\Models\Configuration\Company;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class CompanyLive extends Component
{
    use WithFileUploads;
    use Toast;
    public $title = 'Company';
    public $sub_title = 'Configuracion de empresa';
    public CompanyForm $companyForm;
    public $type_code = 'ruc';
    public Company $company;
    #[Rule('required|max:1000')]
    public $certificado;

    #[Rule('required|max:1000')]
    public $logo;

    public function render()
    {
        $this->company = Company::first();
        $this->companyForm->setCompany($this->company);
        return view('livewire.configuration.company-live');
    }
    public function save()
    {
        //dump($this->companyForm);
        if ($this->companyForm->update()) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function saveArchive()
    {
        if (gettype($this->logo) != 'string' and $this->logo != null) {
            Storage::delete($this->company->logo_path);
            $this->company->logo_path = $this->logo->store('company/logo');
            $this->company->save();
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
        if (gettype($this->certificado) != 'string' and $this->certificado != null) {
            Storage::delete($this->company->cert_path);
            $this->company->cert_path = $this->certificado->store('company/certificado');
            $this->company->save();
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
}
