<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class ScheduleMeeting extends Component
{
    public $contact_id = "";
    public $title = "";
    public $scheduled_at = "";

    public function saveMeeting()
    {
        $this->validate([
            "contact_id" => "required|exists:contacts,id",
            "title" => "required|string|max:255",
            "scheduled_at" => "required|date|after:now",
        ]);

        Appointment::query()->create([
            "user_id" => Auth::id(),
            "contact_id" => $this->contact_id,
            "title" => $this->title,
            "scheduled_at" => $this->scheduled_at,
        ]);

        $this->reset(["contact_id", "title", "scheduled_at"]);
        session()->flash("success", "Meeting successfully scheduled!");
    }

    public function render()
    {
        return view("components.schedule-meeting", [
            // Using 'components.' just like last time!
            "contacts" => Contact::query()
                ->where("owner_id", Auth::id())
                ->get(),
            "appointments" => Appointment::query()
                ->where("user_id", Auth::id())
                ->orderBy("scheduled_at", "asc")
                ->get(),
        ]);
    }
}
