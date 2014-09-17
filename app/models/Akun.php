<?php

Class Akun extends Eloquent{
	protected $table ='tb_akun';
	public $timestamps = false;
	protected $fillable = ['akun','kd_rekening'];
}