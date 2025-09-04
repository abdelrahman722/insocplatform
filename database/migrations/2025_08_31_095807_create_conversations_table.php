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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('user_id_1');
            $table->string('user_id_2');
            $table->string('title')->nullable(); // مثلاً: "محادثة حول أحمد"
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // فريدة: لا يمكن أن يكون هناك أكثر من محادثة واحدة بين نفس الزوج
            $table->unique(['user_id_1', 'user_id_2']);
            $table->unique(['user_id_2', 'user_id_1']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
