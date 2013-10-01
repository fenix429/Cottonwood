<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('title');
			$table->string('link');
			$table->text('summary');
			$table->text('content');
			$table->string('hash')->unique();
			$table->integer('timestamp');
			$table->boolean('unread')->default(TRUE);
			$table->integer('feed_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}