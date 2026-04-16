<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Services\CRMService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DealController extends Controller
{
    /**
     * Update the stage of a deal and trigger necessary side effects.
     *
     * @param Request $request
     * @param Deal $deal
     * @param CRMService $crmService
     * @return JsonResponse
     */
    public function updateStage(
        Request $request,
        Deal $deal,
        CRMService $crmService,
    ): JsonResponse {
        $validated = $request->validate([
            "stage" =>
                "required|string|in:Discovery,Proposal,Negotiation,Closed Won,Closed Lost",
        ]);

        // Update the deal
        $deal->update(["stage" => $validated["stage"]]);

        // If the deal is won, trigger the service to convert the lead
        if ($deal->stage === "Closed Won") {
            $crmService->convertLeadToCustomer($deal->contact_id);
        }

        return response()->json([
            "message" => "Deal stage updated successfully.",
            "deal" => $deal,
            "insight" => $crmService->getDealInsights($deal->id),
        ]);
    }
}
