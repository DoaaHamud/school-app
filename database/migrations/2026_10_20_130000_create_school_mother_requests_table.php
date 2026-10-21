<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_mother_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mother_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->unique(['school_id', 'mother_id']);
            $table->index(['school_id', 'status']);
        });

        DB::table('users')
            ->where('role', 'mother')
            ->whereNotNull('school_id')
            ->orderBy('id')
            ->chunkById(500, function ($mothers) {
                foreach ($mothers as $mother) {
                    DB::table('school_mother_requests')->insertOrIgnore([
                        'school_id' => $mother->school_id,
                        'mother_id' => $mother->id,
                        'status' => 'approved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });

        DB::table('users')
            ->where('role', 'mother')
            ->update(['school_id' => null, 'school_name' => null]);
    }

    public function down(): void
    {
        $singleSchoolMothers = DB::table('school_mother_requests')
            ->select('mother_id', DB::raw('MIN(school_id) as school_id'))
            ->where('status', 'approved')
            ->groupBy('mother_id')
            ->havingRaw('COUNT(DISTINCT school_id) = 1')
            ->get();

        foreach ($singleSchoolMothers as $membership) {
            DB::table('users')
                ->where('id', $membership->mother_id)
                ->update([
                    'school_id' => $membership->school_id,
                    'school_name' => DB::table('schools')
                        ->where('id', $membership->school_id)
                        ->value('name'),
                ]);
        }

        Schema::dropIfExists('school_mother_requests');
    }
};
