<?php

Class Bidang extends Eloquent{
	protected $table ='tb_bidang';
	public $timestamps = false;
	protected $fillable = ['id_kewenangan','kode_bidang','bidang','regulasi','tanggal','pengundangan'];

}