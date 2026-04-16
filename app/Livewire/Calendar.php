<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;

    public function mount()
    {
        // Start on the current month and year
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function previousMonth()
    {
        $date = Carbon::create(
            $this->currentYear,
            $this->currentMonth,
        )->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::create(
            $this->currentYear,
            $this->currentMonth,
        )->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function render()
    {
        // 1. Figure out the exact start and end of our calendar grid
        $date = Carbon::createFromDate(
            $this->currentYear,
            $this->currentMonth,
            1,
        );
        $startOfCalendar = $date
            ->copy()
            ->startOfMonth()
            ->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $date
            ->copy()
            ->endOfMonth()
            ->endOfWeek(Carbon::SATURDAY);

        // 2. Fetch all appointments in this visual range
        $appointments = Appointment::with("contact")
            ->where("user_id", Auth::id())
            ->whereBetween("scheduled_at", [$startOfCalendar, $endOfCalendar])
            ->get()
            ->groupBy(function ($apt) {
                return Carbon::parse($apt->scheduled_at)->format("Y-m-d");
            });

        // 3. Build the array of days to pass to the frontend
        $days = [];
        $period = CarbonPeriod::create($startOfCalendar, $endOfCalendar);

        foreach ($period as $day) {
            $days[] = [
                "date" => $day->format("Y-m-d"),
                "dayNumber" => $day->day,
                "isCurrentMonth" => $day->month === $this->currentMonth,
                "isToday" => $day->isToday(),
                "appointments" => $appointments->get($day->format("Y-m-d"), []),
            ];
        }

        return view("components.calendar", [
            "days" => $days,
            "currentDateStr" => $date->format("F Y"), // e.g., "March 2026"
        ]);
    }
}
