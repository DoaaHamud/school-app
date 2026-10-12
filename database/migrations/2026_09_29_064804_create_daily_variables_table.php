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
        Schema::create('daily_variables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('chaldrins')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('topic');
            $table->decimal('result', 5, 2)->nullable();
            $table->string('notes')->nullable();
            $table->dateTime('report_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_variables');
    }
};
