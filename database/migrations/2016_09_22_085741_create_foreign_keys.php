<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('categories', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cash', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('movements', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('balance', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('balance', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('balance', function(Blueprint $table) {
			$table->foreign('cash_id')->references('id')->on('cash')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('description_day', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('categories', function(Blueprint $table) {
			$table->dropForeign('categories_user_id_foreign');
		});
		Schema::table('cash', function(Blueprint $table) {
			$table->dropForeign('cash_user_id_foreign');
		});
		Schema::table('movements', function(Blueprint $table) {
			$table->dropForeign('movements_user_id_foreign');
		});
		Schema::table('balance', function(Blueprint $table) {
			$table->dropForeign('balance_user_id_foreign');
		});
		Schema::table('balance', function(Blueprint $table) {
			$table->dropForeign('balance_category_id_foreign');
		});
		Schema::table('balance', function(Blueprint $table) {
			$table->dropForeign('balance_cash_id_foreign');
		});
		Schema::table('description_day', function(Blueprint $table) {
			$table->dropForeign('description_day_user_id_foreign');
		});
	}
}