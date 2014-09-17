<?php

Class Kelompok extends Eloquent{
	protected $table ='tb_akun_kelompok';
	public $timestamps = false;
	protected $fillable = ['akun_id','kelompok','kd_rekening'];

	public function akun(){
		return $this->belongsTo('Akun','akun_id');
	}
}