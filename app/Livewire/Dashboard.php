<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Deal;
use App\Models\Interaction;
use App\Models\Task;
class Dashboard extends Component
{
    public function render()
    {
        // Get counts for each stage to build the funnel
        $funnelData = [
            "Discovery" => Deal::query()->where("stage", "Discovery")->count(),
            "Proposal" => Deal::query()->where("stage", "Proposal")->count(),
            "Negotiation" => Deal::query()
                ->where("stage", "Negotiation")
                ->count(),
            "Won" => Deal::query()->where("stage", "Closed Won")->count(),
        ];

        // Get the 5 most recent activities for the sidebar/bottom feed
        $recentActivities = Interaction::with("contact")
            ->latest()
            ->take(5)
            ->get();

        $userId = Auth::id();

        // 1. Top Level Stats
        $pipelineTotal = Deal::where("user_id", $userId)
            ->whereNotIn("stage", ["Closed Lost"])
            ->sum("amount");

        $wonTotal = Deal::where("user_id", $userId)
            ->where("stage", "Closed Won")
            ->sum("amount");

        // 2. Chart Data: Group deals by stage and sum the amounts
        $dealsByStage = Deal::where("user_id", $userId)
            ->selectRaw("stage, sum(amount) as total")
            ->groupBy("stage")
            ->pluck("total", "stage")
            ->toArray();

        // Ensure all stages exist in the array for the chart even if they are $0
        $stages = [
            "Discovery",
            "Proposal",
            "Negotiation",
            "Closed Won",
            "Closed Lost",
        ];
        $chartData = [];
        foreach ($stages as $stage) {
            $chartData[$stage] = $dealsByStage[$stage] ?? 0;
        }

        // 3. Actionable Items
        $tasksToday = Task::with("contact")
            ->where("user_id", $userId)
            ->whereDate("due_date", "<=", today())
            ->where("status", "!=", "Complete")
            ->orderBy("due_date")
            ->take(3)
            ->get();

        // 4. Activity Feed
        $recentInteractions = Interaction::with("contact")
            ->where("user_id", $userId)
            ->orderBy("interaction_date", "desc")
            ->take(5)
            ->get();
        return view("dashboard", [
            // Sum of deals closed today
            "todayRevenue" => Deal::query() // Add ::query() here
                ->where("stage", "Closed Won")
                ->whereDate("updated_at", now())
                ->sum("amount"),

            // Count of calls/emails today
            "callCount" => Interaction::query()
                ->where("type", "Call")
                ->whereDate("created_at", now())
                ->count(),

            "emailCount" => Interaction::query()
                ->where("type", "Email")
                ->whereDate("created_at", now())
                ->count(),

            "funnelData" => $funnelData,
            "recentActivities" => $recentActivities,
            "pipelineTotal" => $pipelineTotal,
            "wonTotal" => $wonTotal,
            "chartLabels" => array_keys($chartData),
            "chartValues" => array_values($chartData),
            "tasksToday" => $tasksToday,
            "recentInteractions" => $recentInteractions,
        ]);
    }
}
