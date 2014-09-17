<?php

Class Program extends Eloquent{
	protected $table ='tb_program';
	public $timestamps = false;
	protected $fillable = ['id_bidang','kode_program','program'];
}