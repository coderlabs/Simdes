<?php

Class Obyek extends Eloquent{
	protected $table ='tb_jenis_obyek';
	public $timestamps = false;
	protected $fillable = ['id_jenis','kd_rekening','obyek','regulasi','tanggal','pengundangan'];

	public function jenis(){
		return $this->belongsTo('Jenis','id_jenis');
	}
}