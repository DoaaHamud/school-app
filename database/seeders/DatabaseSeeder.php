<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\chaldrin;
use App\Models\Daily_variables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. حساب الأدمن الأساسي الموجود لديك مسبقاً
        // نستخدم firstOrCreate لكي لا يتكرر إنشاء الأدمن إذا قمتِ بتشغيل الأمر أكثر من مرة
        User::firstOrCreate(
            ['email' => 'admin@system.com'],
            [
                'name'        => 'Super Admin',
                'username'    => 'admin',
                'password'    => Hash::make('Admin123456789'),
                'role'        => 'admin',
                'status'      => 'approved',
                'phone'       => '963900000000',
            ]
        );

        // 2. التحقق من وجود أمهات ومعلمين في النظام لتوليد البيانات فوقهم
        $mothersCount = User::where('role', 'mother')->count();
        if ($mothersCount === 0) {
            $this->command->info('ملاحظة: لا توجد أمهات مسجلات حالياً في قاعدة البيانات لتوليد الأطفال تحتهن.');
            return;
        }

        $this->command->info('جاري توليد عدد كبير من الأطفال والتقارير...');

        // 3. تحديد العدد الكبير الذي تريدينه (مثلاً: إضافة 500 طفل جديد)
        $totalChildrenToCreate = 500;

        chaldrin::factory($totalChildrenToCreate)->create()->each(function ($child) {
            // جلب معلمة تابعة لنفس مدرسة الطفل لتسجيل التقارير باسمها
            $teacher = User::where('role', 'teacher')
                ->where('school_id', $child->school_id)
                ->inRandomOrder()
                ->first();

            if ($teacher) {
                // ربط الطفل بالمعلمة في جدول الـ Pivot
                $child->teachers()->syncWithoutDetaching([$teacher->id]);

                // إنشاء تقارير يومية وهمية لكل طفل (بين 3 إلى 8 تقارير)
                $reportsCount = rand(3, 30);
                for ($i = 0; $i < $reportsCount; $i++) {
                    Daily_variables::create([
                        'child_id'    => $child->id,
                        'teacher_id'  => $teacher->id,
                        'topic'       => fake()->randomElement(['رياضيات', 'لغة عربية', 'رسم', 'نشاط حركي', 'علوم مبسطة']),
                        'result'      => fake()->randomFloat(2, 50, 100), // نتيجة بين 50 و 100
                        'notes'       => fake()->sentence(),
                        'report_date' => fake()->dateTimeBetween('-2 months', 'now'), // تقارير موزعة خلال الشهرين الماضيين
                    ]);
                }
            }
        });

        $this->command->info('تم إضافة الأطفال والتقارير بنجاح دون المساس ببياناتك السابقة!');
    }
}
