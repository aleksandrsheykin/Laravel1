<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMovementsTable extends Migration {

	public function up()
	{
		Schema::create('movements', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('cash_id_from');
			$table->integer('cash_id_to');
			$table->decimal('summa', 10,2);
			$table->text('description');
			$table->date('datemov');
		});
	}

	public function down()
	{
		Schema::drop('movements');
	}
}