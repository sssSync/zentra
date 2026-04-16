<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Interaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
class TaskBoard extends Component
{
    // Variables for the Interaction Popup
    public $selectedInteraction = null;
    public $isModalOpen = false;

    // Moves the task between Kanban columns
    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::query()->find($taskId);
        // 2. Security Check: Make sure it's a valid column!
        $validStatuses = ["Todo", "In Progress", "Complete"];

        // 3. Update the database
        if ($task && in_array($newStatus, $validStatuses)) {
            $task->update(["status" => $newStatus]);
        }
    }

    // Opens the Popup with the correct Interaction details
    public function viewInteraction($interactionId)
    {
        $this->selectedInteraction = Interaction::with("contact")->find(
            $interactionId,
        );
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedInteraction = null;
    }
    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->delete();
        }
    }
    #[On("task-created")]
    public function refreshBoard()
    {
        // Livewire will automatically re-run render() when this is called
    }
    public function render()
    {
        // Fetch all tasks for this user, grouped by their Kanban status
        $tasks = Task::with(["contact", "interaction"])
            ->where("user_id", Auth::id())
            ->get()
            ->groupBy("status");

        return view("components.task-board", [
            "tasks" => $tasks,
        ]);
    }
}
