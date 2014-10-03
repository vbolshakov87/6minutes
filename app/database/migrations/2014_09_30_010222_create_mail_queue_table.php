<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailQueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mail_queues', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('subject');
			$table->string('to');
			$table->enum('type', array('user', 'moderator'))->default('moderator');
			$table->text('data');
			$table->enum('status', array('pending', 'in process', 'done', 'failed'))->default('pending');
			$table->index('status');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mail_queues');
	}

}
