<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email', 50);
			$table->string('password', 255);
			$table->string('name', 100);
			$table->boolean('admin');
			$table->string('remember_token', 255)->nullable();
			$table->integer('organisasi_id')->nullable();
			$table->string('slug', 255)->nullable();
			$table->string('organisasi', 255)->nullable();
			$table->boolean('is_pejabat')->nullable();
			$table->boolean('is_organisasi')->nullable();
			$table->boolean('is_fungsi')->nullable();
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
		Schema::drop('users');
	}

}
