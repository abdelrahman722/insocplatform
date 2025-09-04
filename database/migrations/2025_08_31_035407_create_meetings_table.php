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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->date('scheduled_date'); // التاريخ المحدد (مثلاً: 2025-09-05)
            $table->text('purpose')->nullable(); // سبب الاجتماع
            $table->text('notes_guardian')->nullable(); // ملاحظات ولي الأمر
            $table->text('notes_teacher')->nullable(); // ملاحظات المدرس
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('available_slot_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained('users')->cascadeOnDelete(); // ولي الأمر
            $table->foreignId('student_id')->nullable()->constrained('students')->cascadeOnDelete(); // الطالب (اختياري)
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // فريدة: لا يمكن حجز نفس الفترة الزمنية لنفس ولي الأمر
            $table->unique(['available_slot_id', 'scheduled_date', 'guardian_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
