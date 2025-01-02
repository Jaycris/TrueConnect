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
        Schema::create('pack_sold_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pack_sold_id');
            $table->unsignedBigInteger('event_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('pack_sold_id')->references('id')->on('package_sold')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pack_sold_event');
    }
};
