<?php

namespace Database\Factories;

use App\Models\School;
use App\Models\User;
use App\Models\chaldrin;
use Illuminate\Database\Eloquent\Factories\Factory;

class chaldrinFactory extends Factory // أو chaldrinFactory حسب اسم الملف لديك
{
    protected $model = chaldrin::class;

    public function definition(): array
    {
        // جلب أم ومدرسة عشوائيين من الموجودين مسبقاً في قاعدة بياناتك
        $mother = User::where('role', 'mother')->inRandomOrder()->first();
        $school = School::inRandomOrder()->first();

        return [
            'mother_id'     => $mother ? $mother->id : 1,
            'school_id'     => $school ? $school->id : 1,
            'name'          => fake()->name(),
            'gender'        => fake()->randomElement(['male', 'female']),
            'Health_status' => 'سليم وصحي',
            'class'         => fake()->randomElement(['التمهيدي', 'البستان', 'الصف الأول', 'الصف الثاني']),
            'section'       => fake()->randomElement(['الشعبة الأولى', 'الشعبة الثانية']),
            'age'           => fake()->numberBetween(4, 8),
            'image'         => 'default.png',
        ];
    }
}
