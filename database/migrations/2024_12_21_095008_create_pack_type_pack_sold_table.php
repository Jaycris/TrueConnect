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
        Schema::create('pack_type_pack_sold', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pack_type_id');
            $table->unsignedBigInteger('pack_sold_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('pack_type_id')->references('id')->on('package_type')->onDelete('cascade');
            $table->foreign('pack_sold_id')->references('id')->on('package_sold')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pack_type_pack_sold');
    }
};
