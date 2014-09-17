<?php

Class SumberDana extends Eloquent{
	protected $table ='tb_sumber_dana';
	public $timestamps = false;
	protected $fillable = ['sumber_dana'];
}