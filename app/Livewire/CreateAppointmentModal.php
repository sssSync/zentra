<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\On;

class CreateAppointmentModal extends Component
{
    public $isOpen = false;
    public $contact_id = '';
    public $title = '';
    public $scheduled_at = '';
    public $status = 'Scheduled';

    // Listens for the dispatch from the Calendar or Contact page
    #[On('open-appointment-modal')]
    public function openModal($id = null)
    {
        $this->reset(['title', 'scheduled_at', 'contact_id']);
        $this->status = 'Scheduled';

        if ($id) {
            $this->contact_id = $id;
            $contact = Contact::find($id);
            if ($contact) {
                $this->title = "Meeting with " . $contact->first_name . ' ' . $contact->last_name;
            }
        }

        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            "scheduled_at" => "required|date|after:now",
            'contact_id' => 'required|exists:contacts,id',
        ]);

        Appointment::create([
            'title' => $this->title,
            'scheduled_at' => $this->scheduled_at,
            'status' => 'Filled', // Matches your migration logic
            'contact_id' => $this->contact_id ?: null,
            'user_id' => auth()->id(),
        ]);

        $this->isOpen = false;

        // Notify the Calendar to refresh its data
        $this->dispatch('appointment-created');
        $this->dispatch('notify', message: 'Meeting scheduled successfully!');
    }

    public function render()
    {
        return view('livewire.create-appointment-modal', [
            'contacts' => Contact::orderBy('first_name')->get(),
        ]);
    }
}
