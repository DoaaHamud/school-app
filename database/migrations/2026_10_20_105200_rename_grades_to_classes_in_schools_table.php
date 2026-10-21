<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('schools', 'grades')) {
            Schema::table('schools', function (Blueprint $table) {
                $table->renameColumn('grades', 'classes');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('schools', 'classes')) {
            Schema::table('schools', function (Blueprint $table) {
                $table->renameColumn('classes', 'grades');
            });
        }
    }
};
