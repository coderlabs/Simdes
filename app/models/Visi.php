<?php

Class Visi extends Eloquent{
	protected $table ='tb_rpjm_visi';
	public $timestamps = false;
	protected $fillable = ['visi','id_rpjm_desa'];

}