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
        Schema::create('posyandu_records', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->date('birth_date');
            $table->integer('age_months');
            $table->float('weight');
            $table->float('height');
            $table->float('bmi');
            $table->string('status_gizi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu_records');
    }
};
