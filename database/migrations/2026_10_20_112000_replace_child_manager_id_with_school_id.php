<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        $schoolIdsByManager = [];
        $managers = DB::table('users')
            ->where('role', 'manager')
            ->orderBy('id')
            ->get(['id', 'school_id', 'school_name', 'name', 'school_logo', 'primary_color']);

        foreach ($managers as $manager) {
            $schoolName = trim((string) ($manager->school_name ?: $manager->name));
            if ($schoolName === '') {
                throw new RuntimeException("Cannot assign a school to manager {$manager->id}.");
            }

            $schoolId = $manager->school_id;
            if ($schoolId === null || !DB::table('schools')->where('id', $schoolId)->exists()) {
                $school = DB::table('schools')->where('name', $schoolName)->first();
                if ($school) {
                    $schoolId = $school->id;
                } else {
                    $color = $manager->primary_color;
                    if (!is_string($color) || !preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
                        $color = '#2563eb';
                    }

                    $schoolId = DB::table('schools')->insertGetId([
                        'name' => $schoolName,
                        'logo' => $manager->school_logo,
                        'color' => $color,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                $schoolName = DB::table('schools')->where('id', $schoolId)->value('name') ?: $schoolName;
            }

            $schoolIdsByManager[$manager->id] = $schoolId;

            DB::table('users')
                ->where('id', $manager->id)
                ->update([
                    'school_id' => $schoolId,
                    'school_name' => $schoolName,
                ]);
            if ($manager->school_name !== null) {
                DB::table('users')
                    ->where('school_name', $manager->school_name)
                    ->whereNull('school_id')
                    ->update(['school_id' => $schoolId]);
            }
        }

        foreach ($schoolIdsByManager as $managerId => $schoolId) {
            DB::table('chaldrins')
                ->where('manager_id', $managerId)
                ->whereNull('school_id')
                ->update(['school_id' => $schoolId]);
        }

        $unassignedChildren = DB::table('chaldrins')
            ->whereNull('school_id')
            ->whereNull('manager_id')
            ->get(['id', 'mother_id']);

        foreach ($unassignedChildren as $child) {
            $motherSchoolId = DB::table('users')
                ->where('id', $child->mother_id)
                ->value('school_id');

            if ($motherSchoolId !== null) {
                DB::table('chaldrins')
                    ->where('id', $child->id)
                    ->update(['school_id' => $motherSchoolId]);
            }
        }

        Schema::table('chaldrins', function (Blueprint $table) {
            $table->dropConstrainedForeignId('manager_id');
        });
    }

    public function down(): void
    {
        Schema::table('chaldrins', function (Blueprint $table) {
            $table->foreignId('manager_id')
                ->nullable()
                ->after('mother_id')
                ->constrained('users')
                ->nullOnDelete();
        });

        $managerIdsBySchool = DB::table('users')
            ->select('school_id', DB::raw('MIN(id) as manager_id'))
            ->where('role', 'manager')
            ->whereNotNull('school_id')
            ->groupBy('school_id')
            ->havingRaw('COUNT(*) = 1')
            ->get();

        foreach ($managerIdsBySchool as $manager) {
            DB::table('chaldrins')
                ->where('school_id', $manager->school_id)
                ->update(['manager_id' => $manager->manager_id]);
        }
    }
};
