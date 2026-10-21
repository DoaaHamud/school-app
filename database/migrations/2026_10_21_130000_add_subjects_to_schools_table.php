<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->text('subjects')->nullable();
        });

        DB::table('schools')
            ->whereNotNull('subject')
            ->whereNull('subjects')
            ->update(['subjects' => DB::raw('subject')]);
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('subjects');
        });
    }
};
