<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->date('date_created')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable(); 
            $table->string('website')->nullable();
            $table->string('lead_miner')->nullable();
            $table->string('type')->nullable();
            $table->string('deals')->nullable();
            $table->string('notes')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('comment')->nullable();
            $table->string('assign_to')->nullable();
            $table->timestamps();
        });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
