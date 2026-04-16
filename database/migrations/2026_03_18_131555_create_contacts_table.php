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
        Schema::create("contacts", function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name")->nullable();
            $table->string('avatar')->nullable();
            $table->string("email")->unique()->nullable();
            $table->string("phone")->nullable();
            $table->string("job_title")->nullable();
            $table->string("status")->default("Lead"); // Lead, Customer, Competitor, Ex-Customer

            // Relationships
            $table
                ->foreignId("company_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table
                ->foreignId("owner_id")
                ->nullable()
                ->constrained("users")
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("contacts");
    }
};
