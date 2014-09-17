<?php

Class Jenis extends Eloquent{
	protected $table ='tb_kelompok_jenis';
	public $timestamps = false;
	protected $fillable = ['id_kelompok','jenis','kd_rekening','referensi'];

	public function kelompok(){
		return $this->belongsTo('Kelompok','id_kelompok');
	}
}