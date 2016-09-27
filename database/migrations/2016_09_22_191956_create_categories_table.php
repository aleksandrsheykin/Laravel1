<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('parent_id')->default('0');
			$table->string('name');
			$table->text('description');
			$table->boolean('is_plus')->default(1);
			$table->boolean('is_visible')->default(1);
			$table->boolean('is_system')->default(0);
			$table->string('colour', 9)->default('FFDAB9');
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}