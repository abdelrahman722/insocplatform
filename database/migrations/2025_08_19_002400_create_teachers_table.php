<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration {

	public function up()
	{
		Schema::create('teachers', function(Blueprint $table) {
			$table->id();
			$table->string('job_number');
			$table->string('job_title');
			$table->string('phone');
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('teachers');
	}
}