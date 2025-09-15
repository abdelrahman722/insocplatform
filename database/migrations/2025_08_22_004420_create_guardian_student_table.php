<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardianStudentTable extends Migration {

	public function up()
	{
		Schema::create('guardian_student', function(Blueprint $table) {
			$table->id();
			$table->foreignId('student_id')->constrained()->cascadeOnDelete();
			$table->foreignId('guardian_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('guardian_student');
	}
}