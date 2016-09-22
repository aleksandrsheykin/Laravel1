<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDescriptionDayTable extends Migration {

	public function up()
	{
		Schema::create('description_day', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->text('description');
			$table->date('dateday');
		});
	}

	public function down()
	{
		Schema::drop('description_day');
	}
}