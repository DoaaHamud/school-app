<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('schools')
            ->select(['id', 'classes', 'sections'])
            ->orderBy('id')
            ->each(function (object $school): void {
                $updates = [];

                foreach (['classes', 'sections'] as $column) {
                    $options = $this->decodeOptions($school->{$column});
                    if ($options !== null) {
                        $updates[$column] = json_encode($options, JSON_THROW_ON_ERROR);
                    }
                }

                if ($updates !== []) {
                    DB::table('schools')
                        ->where('id', $school->id)
                        ->update($updates);
                }
            });
    }

    public function down(): void
    {
        DB::table('schools')
            ->select(['id', 'classes', 'sections'])
            ->orderBy('id')
            ->each(function (object $school): void {
                $updates = [];

                foreach (['classes', 'sections'] as $column) {
                    $options = json_decode($school->{$column}, true);
                    if (is_array($options)) {
                        $updates[$column] = json_encode(implode('، ', $options), JSON_THROW_ON_ERROR);
                    }
                }

                if ($updates !== []) {
                    DB::table('schools')
                        ->where('id', $school->id)
                        ->update($updates);
                }
            });
    }

    private function decodeOptions(?string $value): ?array
    {
        if ($value === null || $value === '') {
            return null;
        }

        $decoded = json_decode($value, true, flags: JSON_THROW_ON_ERROR);
        if (is_array($decoded)) {
            $options = $decoded;
        } else {
            $options = preg_split('/[,،\r\n]+/u', (string) $decoded) ?: [];
        }

        return collect($options)
            ->map(fn ($option) => trim((string) $option))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
};
