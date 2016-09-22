<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('parent_id');
			$table->string('name');
			$table->text('description');
			$table->boolean('is_plus');
			$table->boolean('is_visible');
			$table->boolean('is_system');
			$table->string('colour', 9);
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}