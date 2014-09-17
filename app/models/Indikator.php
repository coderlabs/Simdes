<?php

Class Indikator extends Eloquent{
	protected $table ='tb_indikator';
	public $timestamps = false;
	protected $fillable = ['indikator'];
}