<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("deals", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("amount", 12, 2)->default(0); // Standard for currency
            $table->string("stage")->default("Discovery"); // Discovery, Proposal, Negotiation, Closed Won/Lost
            $table->date("expected_close_date")->nullable();
            // Relationships
            $table->foreignId("contact_id")->constrained()->cascadeOnDelete();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("deals");
    }
};
