<?php

Class Desa extends Eloquent{
	protected $table ='tb_master_desa';
	public $timestamps = false;
	protected $fillable = ['kode_kec','kode_desa','desa'];

}