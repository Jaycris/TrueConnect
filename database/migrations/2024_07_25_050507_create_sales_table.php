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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date_created')->nullable();
            $table->string('consultant')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('Service')->nullable();
            $table->string('books')->nullable();
            $table->integer('quantity');
            $table->decimal('amount', 8, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
