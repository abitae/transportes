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
        if ($this->companyForm->update()) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function saveArchive()
    {
        $this->saveFile($this->logo, 'logo_path', 'company/logo');
        $this->saveFile($this->certificado, 'cert_path', 'company/certificado');
    }

    private function saveFile($file, $pathField, $directory)
    {
        if (gettype($file) != 'string' && $file != null) {
            Storage::delete($this->company->$pathField);
            $this->company->$pathField = $file->store($directory);
            $this->company->save();
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
}
