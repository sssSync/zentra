<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;

class ContactPipeline extends Component
{
    // These match the 'status' column in your database
    public $statuses = ["Lead", "Customer", "Competitor", "Ex-Customer"];

    // This handles moving a contact to a new column
    public function updateContactStatus($contactId, $newStatus)
    {
        $contact = Contact::query()->find($contactId);

        if ($contact && in_array($newStatus, $this->statuses)) {
            $contact->update(["status" => $newStatus]);
        }
    }
    public function render()
    {
        return view("contact-pipeline", [
            // "contacts" => Contact::with("company")->get(),
            "contacts" => Contact::all(),
        ]);
    }
}
