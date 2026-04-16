<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Company;
use Livewire\Attributes\On;
class ShowContact extends Component
{
    public Contact $contact;
    public ?Company $company;

    // Contact Fields
    public $first_name, $last_name, $email, $phone, $job_title, $status;

    // Company Fields
    public $company_name, $company_industry, $company_website, $company_address;

    // --- DEAL TRACKER VARIABLES ---
    public $is_creating_deal = false;
    public $deal_name = "";
    public $deal_amount = "";
    public $deal_stage = "Discovery";
    public $deal_expected_close_date = "";

    public function mount(Contact $contact)
    {
        $this->contact = $contact;
        $this->company = $contact->company; // Load the related company if it exists

        // Pre-fill the contact form
        $this->first_name = $contact->first_name;
        $this->last_name = $contact->last_name;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->job_title = $contact->job_title;
        $this->status = $contact->status;

        // Pre-fill the company form
        if ($this->company) {
            $this->company_name = $this->company->name;
            $this->company_industry = $this->company->industry;
            $this->company_website = $this->company->website;
            $this->company_address = $this->company->address;
        }
    }

    public function update()
    {
        // 1. Validate the inputs (Notice we ignore the current contact's email for the unique check!)
        $this->validate([
            "first_name" => "required|min:2",
            "email" =>
                "nullable|email|unique:contacts,email," . $this->contact->id,
            "status" => "required|string",
            "company_name" => "nullable|string|max:255",
        ]);

        // 2. Update Contact
        $this->contact->update([
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "phone" => $this->phone,
            "job_title" => $this->job_title,
            "status" => $this->status,
        ]);

        // 3. Update or Create Company
        if ($this->company_name) {
            if ($this->company) {
                // Update existing company
                $this->company->update([
                    "name" => $this->company_name,
                    "industry" => $this->company_industry,
                    "website" => $this->company_website,
                    "address" => $this->company_address,
                ]);
            } else {
                // Create a new company if they added one and attach it
                $newCompany = Company::create([
                    "name" => $this->company_name,
                    "industry" => $this->company_industry,
                    "website" => $this->company_website,
                    "address" => $this->company_address,
                ]);
                $this->contact->update(["company_id" => $newCompany->id]);
                $this->company = $newCompany;
            }
        }

        session()->flash("success", "Profile updated successfully!");
    }

    public function delete()
    {
        $this->contact->delete();
        // Redirect back to the pipeline after deletion
        return redirect()->route("contacts.index");
    }

    public function toggleDealForm()
    {
        $this->is_creating_deal = !$this->is_creating_deal;
        $this->reset([
            "deal_name",
            "deal_amount",
            "deal_stage",
            "deal_expected_close_date",
        ]); // Clear form if they cancel
    }

    public function saveDeal()
    {
        $this->validate([
            "deal_name" => "required|string|max:255",
            "deal_amount" => "nullable|numeric|min:0",
            "deal_stage" => "required|string",
            "deal_expected_close_date" => "nullable|date",
        ]);

        // Create the deal directly attached to this contact
        $this->contact->deals()->create([
            "user_id" => \Illuminate\Support\Facades\Auth::id(),
            "name" => $this->deal_name,
            "amount" => $this->deal_amount,
            "stage" => $this->deal_stage,
            "expected_close_date" => $this->deal_expected_close_date,
        ]);

        $this->reset([
            "deal_name",
            "deal_amount",
            "deal_stage",
            "deal_expected_close_date",
            "is_creating_deal",
        ]);

        // Refresh the contact so the new deal shows up instantly
        $this->contact->refresh();
        session()->flash(
            "success",
            "Deal successfully attached to this contact!",
        );
    }

    // --- INTERACTION / LOG VARIABLES ---
    public $is_logging_interaction = false;
    public $interaction_type = "Note";
    public $interaction_content = "";

    // --- TASK VARIABLES ---
    public $is_adding_task = false;
    public $task_title = "";
    public $task_due_date = "";
    public $task_interaction_id = "";

    // --- INTERACTION LOGIC ---
    public function toggleInteractionForm()
    {
        $this->is_logging_interaction = !$this->is_logging_interaction;
        $this->is_adding_task = false; // Close task form if open
        $this->reset(["interaction_content"]);
        $this->interaction_type = "Note"; // Default value
    }

    public function saveInteraction()
    {
        $this->validate([
            "interaction_type" => "required|string",
            "interaction_content" => "required|string",
        ]);

        $this->contact->interactions()->create([
            "user_id" => \Illuminate\Support\Facades\Auth::id(),
            "type" => $this->interaction_type,
            "content" => $this->interaction_content,
            "interaction_date" => now(), // Automatically logs it at the current exact time
        ]);

        $this->reset(["is_logging_interaction", "interaction_content"]);
        $this->contact->refresh();
        session()->flash("success", "Interaction logged successfully!");
    }

    // MODEL open
    #[On("task-created")]
    #[On("deal-created")]
    public function refreshProfile()
    {
        $this->contact->refresh();
    }

    // --- TASK LOGIC ---
    public function saveTask()
    {
        $this->validate([
            "task_title" => "required|string|max:255",
            "task_due_date" => "nullable|date",
            "task_interaction_id" => "nullable|exists:interactions,id",
        ]);

        $this->contact->tasks()->create([
            "user_id" => \Illuminate\Support\Facades\Auth::id(),
            "title" => $this->task_title,
            "due_date" => $this->task_due_date,
            "interaction_id" => $this->task_interaction_id ?: null,
        ]);

        $this->reset([
            "is_adding_task",
            "task_title",
            "task_due_date",
            "task_interaction_id",
        ]);
        $this->contact->refresh();
        session()->flash("success", "Task added successfully!");
    }

    public function toggleTaskCompletion($taskId)
    {
        $task = \App\Models\Task::find($taskId);
        if ($task) {
            $task->update(["is_completed" => !$task->is_completed]);
            $this->contact->refresh();
        }
    }

    public function render()
    {
        return view("components.show-contact");
    }
}
