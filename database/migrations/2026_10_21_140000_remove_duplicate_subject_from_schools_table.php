<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('schools', 'subject')) {
            return;
        }

        if (Schema::hasColumn('schools', 'subjects')) {
            DB::table('schools')
                ->whereNotNull('subject')
                ->whereNull('subjects')
                ->update(['subjects' => DB::raw('subject')]);
        }

        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('subject');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('schools', 'subject')) {
            return;
        }

        Schema::table('schools', function (Blueprint $table) {
            $table->string('subject')->nullable();
        });

        if (Schema::hasColumn('schools', 'subjects')) {
            DB::table('schools')
                ->whereNotNull('subjects')
                ->update(['subject' => DB::raw('subjects')]);
        }
    }
};
