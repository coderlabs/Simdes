<?php

Class Prioritas extends Eloquent{
	protected $table ='tb_prioritas';
	public $timestamps = false;
	protected $fillable = ['kode_prioritas','prioritas'];
}