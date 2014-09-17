<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbRencanaBelanjaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_rencana_belanja', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('belanja_id')->nullable();
			$table->text('uraian')->nullable();
			$table->integer('ssh_id')->nullable();
			$table->string('kegiatan', 255)->nullable();
			$table->string('jumlah_item', 20)->nullable();
			$table->string('jumlah', 20)->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('organisasi_id')->nullable();
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
		Schema::drop('tb_rencana_belanja');
	}

}
