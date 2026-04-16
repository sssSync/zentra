<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Deal;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class CreateDealModal extends Component
{
    public $isOpen = false;

    // Form Fields
    public $name = "";
    public $amount = "";
    public $expected_close_date = "";
    public $contact_id = "";
    public $stage = "Discovery"; // Default starting stage

    public $is_prefilled_contact = false;

    // Listens for ANY page to dispatch 'open-deal-modal'
    #[On("open-deal-modal")]
    public function openModal($contactId = null)
    {
        $this->reset(["name", "amount", "expected_close_date", "stage"]);
        $this->stage = "Discovery";

        // Lock in the contact if opened from a Contact Profile
        if ($contactId) {
            $this->contact_id = $contactId;
            $this->is_prefilled_contact = true;
        } else {
            $this->contact_id = "";
            $this->is_prefilled_contact = false;
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function save()
    {
        $this->validate([
            "name" => "required|string|max:255",
            "contact_id" => "required|exists:contacts,id",
            "amount" => "required|numeric|min:0",
            "expected_close_date" => "nullable|date",
            "stage" => "required|string",
        ]);

        Deal::create([
            "user_id" => Auth::id(),
            "contact_id" => $this->contact_id,
            "name" => $this->name,
            "amount" => $this->amount,
            "expected_close_date" => $this->expected_close_date,
            "stage" => $this->stage,
        ]);

        $this->closeModal();

        // Shout to the parent page that a deal was created so it can refresh!
        $this->dispatch("deal-created");
    }

    public function render()
    {
        return view("livewire.create-deal-modal", [
            "contacts" => Contact::orderBy("first_name")->get(),
        ]);
    }
}
