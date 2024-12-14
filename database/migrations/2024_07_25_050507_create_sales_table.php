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
            $table->string('s_id')->unique();
            $table->date('date_sold')->nullable();
            $table->string('consultant')->nullable();
            $table->string('author_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('book_title')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('mailing_address')->nullable();
            $table->string('pack_type')->nullable();
            $table->string('pack_sold')->nullable();
            $table->string('service_stage')->nullable();
            $table->decimal('total_price', 8, 2)->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('method')->nullable();
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
