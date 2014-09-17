<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbBelanjaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_belanja', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->date('tahun')->nullable();
			$table->integer('kelompok_id')->nullable();
			$table->integer('jenis_id')->nullable();
			$table->integer('obyek_id')->nullable();
			$table->integer('rincian_obyek_id')->nullable();
			$table->string('volume_1', 11)->nullable();
			$table->string('volume_2', 11)->nullable();
			$table->string('volume_3', 11)->nullable();
			$table->string('satuan_1', 24)->nullable();
			$table->string('satuan_2', 24)->nullable();
			$table->string('satuan_3', 24)->nullable();
			$table->string('jumlah', 20)->nullable();
			$table->string('belanja', 255)->nullable();
			$table->string('satuan_harga', 11)->nullable();
			$table->integer('organisasi_id')->nullable();
			$table->integer('kegiatan_id')->nullable();
			$table->string('jenis_belanja', 20)->nullable();
			$table->string('kegiatan', 255)->nullable();
			$table->integer('rkpdesa_id')->nullable();
			$table->string('pagu_anggaran', 20)->nullable();
			$table->boolean('is_rka')->nullable();
			$table->boolean('is_dpa')->nullable();
			$table->datetime('date_rka')->nullable();
			$table->string('realisasi', 50)->nullable();
			$table->string('kode_rekening', 50)->nullable();
			$table->string('januari', 20)->nullable();
			$table->string('februari', 20)->nullable();
			$table->string('maret', 20)->nullable();
			$table->string('april', 20)->nullable();
			$table->string('mei', 20)->nullable();
			$table->string('juni', 20)->nullable();
			$table->string('juli', 20)->nullable();
			$table->string('agustus', 20)->nullable();
			$table->string('september', 20)->nullable();
			$table->string('oktober', 20)->nullable();
			$table->string('november', 20)->nullable();
			$table->string('desember', 20)->nullable();
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
		Schema::drop('tb_belanja');
	}

}
