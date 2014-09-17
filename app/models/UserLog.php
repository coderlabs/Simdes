<?php

Class UserLog extends Eloquent{
	protected $table ='tb_user_log';
	public $timestamps = false;
	protected $fillable = ['user_id','nama','jenis','deskripsi','created_at'];
	
}