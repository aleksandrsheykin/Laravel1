<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCashTable extends Migration {

	public function up()
	{
		Schema::create('cash', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('name');
			$table->decimal('summa', 10,2);
			$table->text('description');
			$table->string('ico');
			$table->boolean('is_basic');
			$table->boolean('is_visible');
			$table->string('colour', 9);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('cash');
	}
}