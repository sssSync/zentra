<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function export()
    {
        $contacts = Contact::query()->with("company")->get();

        // Logic to generate CSV and return download
        // (We will implement the library for this later)
        return response()->streamDownload(function () use ($contacts) {
            // CSV Generation Logic
        }, "contacts_export.csv");
    }
}
