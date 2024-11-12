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

    public function setCompany(Company $company){
        $this->company = $company;
        $this->ruc = $company->ruc;
        $this->razonSocial = $company->razonSocial;
        $this->address = $company->address;
        $this->email = $company->email;
        $this->telephone = $company->telephone;
        $this->sol_user = $company->sol_user;
        $this->sol_pass = $company->sol_pass;
        $this->client_id = $company->client_id;
        $this->client_secret = $company->client_secret;
        $this->production = $company->production;
    }
    public function store()
    {
        try {
            $this->validate();
            $company = Company::create($this->validate());
            $this->infoLog('Company store ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Company store', $e);
            return false;
        }
    }
    public function update()
    {
        try {

            $this->company->update(
                [
                    'ruc' => $this->ruc,
                    'razonSocial' => $this->razonSocial,
                    'address' => $this->address,
                    'email' => $this->email,
                    'telephone' => $this->telephone,
                    'sol_user' => $this->sol_user,
                    'sol_pass' => $this->sol_pass,
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'production' => $this->production,
                ]
            );
            $this->infoLog('Company update ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Company update', $e);
            return false;
        }
    }

}
