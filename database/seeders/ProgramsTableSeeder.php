<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramsTableSeeder extends Seeder
{
    public function run()
    {
        $programs = [
            [
                'name' => 'التواصل المدرسي',
                'code' => 'NOTIFLY',
                'description' => 'برنامج التواصل بين المدرسة وأولياء الأمور',
                'icon' => 'chat-bubble-left-right',
                'is_active' => true
            ],
            [
                'name' => 'المقصف الذكي',
                'code' => 'SMART_CANTEEN',
                'description' => 'إدارة المقصف والمحفظة المالية',
                'icon' => 'building-storefront',
                'is_active' => true
            ],
            [
                'name' => 'التواصل التعليمي',
                'code' => 'EDUCONNECT',
                'description' => 'نظام التواصل التعليمي',
                'icon' => 'academic-cap',
                'is_active' => false
            ],
            [
                'name' => 'الرقابة الذكية',
                'code' => 'SMCT',
                'description' => 'نظام المراقبة الذكية',
                'icon' => 'shield-check',
                'is_active' => false
            ]
        ];

        foreach ($programs as $program) {
            // استخدام updateOrCreate لتجنب التكرار
            Program::updateOrCreate(
                ['code' => $program['code']], // البحث بالكود الفريد
                $program // البيانات للتحديث أو الإنشاء
            );
        }
    }
}