<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class DealBoard extends Component
{
    // Variables for the Details Modal
    public $selectedDeal = null;
    public $isViewModalOpen = false;

    // --- NEW METHODS FOR THE POPUP & DELETE ---
    public function viewDeal($dealId)
    {
        $this->selectedDeal = Deal::with("contact")->find($dealId);
        $this->isViewModalOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewModalOpen = false;
        $this->selectedDeal = null;
    }

    public function deleteDeal($dealId)
    {
        $deal = Deal::query()->find($dealId);
        if ($deal) {
            $deal->delete();
        }
        $this->closeViewModal();
    }
    // ------------------------
    public function updateDealStage($dealId, $newStage)
    {
        $deal = Deal::query()->find($dealId);

        $validStages = [
            "Discovery",
            "Proposal",
            "Negotiation",
            "Closed Won",
            "Closed Lost",
        ];

        if ($deal && in_array($newStage, $validStages)) {
            $deal->update(["stage" => $newStage]);
        }
    }
    #[On("deal-created")]
    public function refreshBoard()
    {
        // Refreshes the board when a new deal is saved
    }
    public function render()
    {
        $deals = Deal::with("contact")
            ->where("user_id", Auth::id())
            ->get()
            ->groupBy("stage");

        return view("components.deal-board", [
            "deals" => $deals,
        ]);
    }
}
