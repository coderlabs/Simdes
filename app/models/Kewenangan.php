<?php

Class Kewenangan extends Eloquent{
	protected $table ='tb_kewenangan';
	public $timestamps = false;
	protected $fillable = ['kode_kewenangan','kewenangan'];

}