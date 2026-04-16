<?php
use App\Livewire\Dashboard;
use App\Livewire\ContactPipeline;
use App\Livewire\CreateLead;
use App\Livewire\ScheduleMeeting;
use App\Livewire\Calendar;
use App\Livewire\ShowContact;
use App\Livewire\TaskBoard;
use App\Livewire\DealBoard;
use App\Livewire\AnalyticsHub;
use Illuminate\Support\Facades\Route;
Route::view("/", "welcome")->name("home");

Route::middleware(["auth", "verified"])->group(function () {
    // Route::view("dashboard", "dashboard")->name("dashboard");
    Route::get("/dashboard", Dashboard::class)->name("dashboard");
    Route::get("/contacts", ContactPipeline::class)->name("contacts.index");
    Route::get("/leads/create", CreateLead::class)->name("leads.create");
    Route::get("/meetings", ScheduleMeeting::class)->name("meetings");
    Route::get("/calendar", Calendar::class)->name("calendar");
    Route::get("/contacts/{contact}", ShowContact::class)->name(
        "contacts.show",
    );
    Route::get("/analytics", AnalyticsHub::class)->name("analytics");
    Route::get("/deals", DealBoard::class)->name("deals.board");
    Route::get("/tasks", TaskBoard::class)->name("tasks.board");
});

require __DIR__ . "/settings.php";
