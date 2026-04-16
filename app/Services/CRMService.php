<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Interaction;
use Illuminate\Support\Facades\Auth;
class CRMService
{
    /**
     * Convert a Lead to a Customer when a deal is won.
     *
     * @param int $contactId
     * @return void
     */
    public function convertLeadToCustomer(int $contactId): void
    {
        $contact = Contact::query()->findOrFail($contactId);
        $contact->update(["status" => "Customer"]);

        // Log the event automatically
        Interaction::query()->create([
            "contact_id" => $contactId,
            "user_id" => Auth::id(),
            "type" => "Note",
            "content" =>
                "Lead automatically converted to Customer via won deal.",
        ]);
    }

    /**
     * Convert a Lead to a Customer when a deal is won.
     *
     * @param int $dealId
     * @return float
     */
    public function getDealInsights(int $dealId): float
    {
        $deal = Deal::query()->findOrFail($dealId);
        $multipliers = [
            "Discovery" => 0.1,
            "Proposal" => 0.5,
            "Negotiation" => 0.8,
            "Closed Won" => 1.0,
        ];

        return $deal->value * ($multipliers[$deal->stage] ?? 0);
    }
}
