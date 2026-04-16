<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Deal;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnalyticsHub extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // ---------------------------------------------------------
        // CHART 1: Revenue Over Time (Last 6 Months Line Chart)
        // ---------------------------------------------------------
        $months = [];
        $revenueData = [];

        // Loop backwards from 5 months ago to this month
        for ($i = 5; $i >= 0; $i--) {
            $targetMonth = Carbon::now()->startOfMonth()->subMonths($i);
            $months[] = $targetMonth->format("M Y"); // e.g., "Oct 2025"

            $revenueData[] = Deal::where("user_id", $userId)
                ->where("stage", "Closed Won")
                ->whereYear("updated_at", $targetMonth->year)
                ->whereMonth("updated_at", $targetMonth->month)
                ->sum("amount");
        }

        // ---------------------------------------------------------
        // CHART 2: Pipeline Health (Doughnut Chart)
        // ---------------------------------------------------------
        $fullStages = [
            "Discovery",
            "Proposal",
            "Negotiation",
            "Closed Won",
            "Closed Lost",
        ];
        $pipelineData = [];

        foreach ($fullStages as $stage) {
            $pipelineData[] = Deal::where("user_id", $userId)
                ->where("stage", $stage)
                ->count(); // Counting HOW MANY deals, not the dollar amount
        }

        // ---------------------------------------------------------
        // 1. DATE LABELS (Last 6 Months)
        // ---------------------------------------------------------

        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()
                ->startOfMonth()
                ->subMonths($i)
                ->format("M");
        }

        // ---------------------------------------------------------
        // 2. LEAD PERFORMANCE (Contacts added per month)
        // ---------------------------------------------------------
        $leadsData = [];
        for ($i = 5; $i >= 0; $i--) {
            $targetMonth = Carbon::now()->startOfMonth()->subMonths($i);
            $leadsData[] = Contact::where("owner_id", $userId)
                ->whereYear("created_at", $targetMonth->year)
                ->whereMonth("created_at", $targetMonth->month)
                ->count();
        }

        // ---------------------------------------------------------
        // 3. DEAL CLOSURE RATE (Won vs Lost)
        // ---------------------------------------------------------
        $wonDeals = Deal::where("user_id", $userId)
            ->where("stage", "Closed Won")
            ->count();
        $lostDeals = Deal::where("user_id", $userId)
            ->where("stage", "Closed Lost")
            ->count();
        $totalClosed = $wonDeals + $lostDeals;

        $closureRate =
            $totalClosed > 0 ? round(($wonDeals / $totalClosed) * 100) : 0;

        // ---------------------------------------------------------
        // 4. STACKED BAR (Pipeline Value by Stage over Time)
        // ---------------------------------------------------------
        $stages = ["Discovery", "Proposal", "Negotiation"]; // Just the active pipeline
        $stackedData = [];

        foreach ($stages as $stage) {
            $stageMonthlyData = [];
            for ($i = 5; $i >= 0; $i--) {
                $targetMonth = Carbon::now()->startOfMonth()->subMonths($i);
                $stageMonthlyData[] = Deal::where("user_id", $userId)
                    ->where("stage", $stage)
                    ->whereYear("updated_at", $targetMonth->year)
                    ->whereMonth("updated_at", $targetMonth->month)
                    ->sum("amount");
            }
            $stackedData[$stage] = $stageMonthlyData;
        }

        return view("components.analytics-hub", [
            "trendLabels" => $months,
            "trendData" => $revenueData,
            "pipelineLabels" => $fullStages,
            "pipelineData" => $pipelineData,
            "months" => $months,
            "leadsData" => $leadsData,
            "closureRate" => $closureRate,
            "stackedData" => $stackedData,
        ]);
    }

    public function exportReport()
    {
        $userId = Auth::id();

        // Fetch all deals with their associated contacts
        $deals = Deal::with("contact")
            ->where("user_id", $userId)
            ->orderBy("created_at", "desc")
            ->get();

        $fileName = "pipeline_report_" . now()->format("Y_m_d") . ".csv";

        // Stream the download directly to the browser
        return response()->streamDownload(function () use ($deals) {
            $file = fopen("php://output", "w");

            // 1. Add the CSV Headers (The column names)
            fputcsv($file, [
                "Deal Name",
                "Contact Name",
                'Amount ($)',
                "Stage",
                "Expected Close",
                "Created Date",
            ]);

            // 2. Add the Data Rows
            foreach ($deals as $deal) {
                fputcsv($file, [
                    $deal->name,
                    $deal->contact
                        ? $deal->contact->first_name .
                            " " .
                            $deal->contact->last_name
                        : "No Contact",
                    $deal->amount,
                    $deal->stage,
                    $deal->expected_close_date
                        ? \Carbon\Carbon::parse(
                            $deal->expected_close_date,
                        )->format("Y-m-d")
                        : "Not Set",
                    $deal->created_at->format("Y-m-d"),
                ]);
            }

            fclose($file);
        }, $fileName);
    }
}
