<?php

Class Capaian extends Eloquent{
	protected $table ='tb_capaian';
	public $timestamps = false;
	protected $fillable = ['tolok_ukur','target','satuan','uraian','id_rkpdesa'];
}