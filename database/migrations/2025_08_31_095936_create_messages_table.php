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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users'); // من أرسل الرسالة
            $table->text('body')->nullable(); // النص
            $table->string('type')->default('text'); // 'text', 'image', 'file', 'audio', 'video_call', 'voice_call'
            $table->string('file_path')->nullable(); // مسار الملف (لصور، صوت، فيديو، ملفات)
            $table->string('file_name')->nullable(); // اسم الملف الأصلي
            $table->unsignedInteger('file_size')->nullable(); // بالبايت
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
