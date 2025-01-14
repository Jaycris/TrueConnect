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
        Schema::create('endorsed_event', function (Blueprint $table) {
            $table->id();
            $table->string('s_id'); // Ensure this is a string to match the type in 'sales'
            $table->foreign('s_id')->references('s_id')->on('sales')->onDelete('cascade');
            $table->string('event_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endorsed_event');
    }
};
