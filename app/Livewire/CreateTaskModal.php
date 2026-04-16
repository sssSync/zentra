<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Task;
use App\Models\Contact;
use App\Models\Interaction;
use Illuminate\Support\Facades\Auth;

class CreateTaskModal extends Component
{
    public $isOpen = false;

    // Form Fields
    public $title = "";
    public $due_date = "";
    public $contact_id = "";
    public $interaction_id = "";

    // Dynamic Dropdown Data
    public $interactions = [];
    public $is_prefilled_contact = false;

    // Listens for ANY page to dispatch 'open-task-modal'
    #[On("open-task-modal")]
    public function openModal($contactId = null)
    {
        $this->reset(["title", "due_date", "interaction_id"]);

        // If opened from a Contact Profile, pre-fill it and lock it!
        if ($contactId) {
            $this->contact_id = $contactId;
            $this->is_prefilled_contact = true;
        } else {
            $this->contact_id = "";
            $this->is_prefilled_contact = false;
        }

        $this->loadInteractions();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    // Automatically triggers when the user selects a Contact from the dropdown
    public function updatedContactId()
    {
        $this->loadInteractions();
        $this->interaction_id = ""; // Reset interaction if contact changes
    }

    public function loadInteractions()
    {
        if ($this->contact_id) {
            $this->interactions = Interaction::where(
                "contact_id",
                $this->contact_id,
            )
                ->orderBy("interaction_date", "desc")
                ->get();
        } else {
            $this->interactions = [];
        }
    }

    public function save()
    {
        $this->validate([
            "title" => "required|string|max:255",
            "contact_id" => "required|exists:contacts,id",
            "due_date" => "nullable|date",
            "interaction_id" => "nullable|exists:interactions,id",
        ]);

        Task::create([
            "user_id" => Auth::id(),
            "contact_id" => $this->contact_id,
            "title" => $this->title,
            "due_date" => $this->due_date,
            "interaction_id" => $this->interaction_id ?: null,
            "status" => "Todo",
        ]);

        $this->closeModal();

        // Shout to the parent page that a task was created so it can refresh!
        $this->dispatch("task-created");
    }

    public function render()
    {
        return view("livewire.create-task-modal", [
            "contacts" => Contact::orderBy("first_name")->get(),
        ]);
    }
}
