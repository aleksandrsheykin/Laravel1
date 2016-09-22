<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalanceTable extends Migration {

	public function up()
	{
		Schema::create('balance', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->integer('cash_id')->unsigned();
			$table->date('datebal');
			$table->decimal('summa', 10,2);
			$table->text('description');
		});
	}

	public function down()
	{
		Schema::drop('balance');
	}
}