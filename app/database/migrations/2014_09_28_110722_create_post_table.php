<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('title');
			$table->string('email');
			$table->text('description');
			$table->timestamps();
			$table->boolean('confirmed')->default(false);
			$table->index('email');
			$table->index('confirmed');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
