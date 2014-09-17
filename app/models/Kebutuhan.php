<?php

Class Kebutuhan extends Eloquent{
	protected $table ='tb_kebutuhan';
	public $timestamps = false;
	protected $fillable = ['kd_kegiatan','kebutuhan','kode_kebutuhan'];
}