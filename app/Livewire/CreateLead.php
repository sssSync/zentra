<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
class CreateLead extends Component
{
    use WithFileUploads;
    // The data we are collecting from the form
    public $first_name = "";
    public $last_name = "";
    public $email = "";
    public $phone = "";
    public $job_title = "";
    public $status = "Lead"; // Default everyone to 'Lead' initially
    // Company Info
    public $company_id = "";
    public $is_creating_company = false; // The toggle switch

    // New Company Fields
    public $new_company_name = "";
    public $new_company_industry = "";
    public $new_company_website = "";
    public $new_company_address = "";
    public $avatar;


    public function toggleCompanyMode()
    {
        $this->is_creating_company = !$this->is_creating_company;
        $this->company_id = "";
    }

    public function save()
    {
        // 1. Validate the input so we don't get junk data
        $this->validate([
            "first_name" => "required|min:2",
            "email" => "required|email|unique:contacts,email",
            "phone" => "nullable|string",
            "job_title" => "nullable|string|max:255",
            'avatar' => 'nullable|image|max:2048',
        ]);

        $avatarPath = null;

        // If they uploaded an image, store it in the "public/avatars" folder
        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
        }

        // Add dynamic validation based on the toggle switch
        if ($this->is_creating_company) {
            $rules["new_company_name"] = "required|string|max:255";
            $rules["new_company_industry"] = "nullable|string|max:255";
            $rules["new_company_website"] = "nullable|url|max:255";
            $rules["new_company_address"] = "nullable|string|max:1000";
        } else {
            $rules["company_id"] = "nullable|exists:companies,id";
        }

        $this->validate($rules);

        //  Handle the Company Creation
        $final_company_id = $this->company_id;

        if ($this->is_creating_company && $this->new_company_name) {
            $company = Company::create([
                "name" => $this->new_company_name,
                "industry" => $this->new_company_industry,
                "website" => $this->new_company_website,
                "address" => $this->new_company_address,
            ]);
            $final_company_id = $company->id;
        }
        // Create the contact and attach it to the logged-in user
        Contact::query()->create([
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            'avatar' => $avatarPath,
            "email" => $this->email,
            "phone" => $this->phone,
            "job_title" => $this->job_title,
            "company_id" => $final_company_id ?: null,
            "status" => $this->status,
            "owner_id" => Auth::id(),
        ]);

        //  Reset the form and show a success message
        $this->reset(["first_name", "last_name", "email", "phone"]);
        session()->flash("success", "Lead successfully added to the pipeline!");

        // Optionally redirect back to the pipeline
        return redirect()->route("contacts.index");
    }

    public function render()
    {
        return view("components.create-lead", [
            "companies" => Company::orderBy("name")->get(),
        ]);
    }
}
