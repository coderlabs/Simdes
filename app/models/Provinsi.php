<?php

Class Provinsi extends Eloquent{
	protected $table ='tb_master_prov';
	public $timestamps = false;
	protected $fillable = ['kode_prov','prov','seo'];

}