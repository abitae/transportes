<?php

namespace App\Livewire\Forms;

use App\Models\Configuration\Company;
use App\Traits\LogCustom;
use Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CompanyForm extends Form
{
    use WithFileUploads;
    use LogCustom;

    public ?Company $company;
    #[Validate(['required', 'string', 'max:11', 'min:11'])]
    public $ruc = '';
    #[Validate(['required', 'string'])]
    public $razonSocial = '';
    #[Validate(['required', 'string', 'max:255'])]
    public $address = '';
    #[Validate(['required', 'string', 'email'])]
    public $email = '';
    #[Validate(['required', 'string'])]
    public $telephone = '';
    #[Validate(['required', 'string'])]
    public $sol_user = '';
    #[Validate(['required', 'string'])]
    public $sol_pass = '';
    #[Validate(['required', 'string'])]
    public $client_id = '';
    #[Validate(['required', 'string'])]
    public $client_secret = '';
    public $production = 0;

    public function setCompany(Company $company)
    {
        $this->company = $company;
        $this->fill($company->toArray());
    }

    public function store()
    {
        return $this->saveCompany(new Company());
    }

    public function update()
    {
        return $this->saveCompany($this->company);
    }

    private function saveCompany(Company $company)
    {
        try {
            $this->validate();
            $company->fill($this->validate())->save();
            $this->infoLog('Company ' . ($company->exists ? 'update' : 'store') . ' ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Company ' . ($company->exists ? 'update' : 'store'), $e);
            return false;
        }
    }
}
