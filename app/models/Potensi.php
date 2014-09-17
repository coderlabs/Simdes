<?php

Class Potensi extends Eloquent{
	protected $table ='tb_rpjm_potensi';
	public $timestamps = false;
	protected $fillable = ['masalah_id','rpjmdesa_id','potensi'];

}