<?php

Class Jabatan extends Eloquent{
	protected $table ='tb_jabatan';
	public $timestamps = false;
	protected $fillable = ['jabatan','sk_nomer','tentang','tanggal','dikeluarkan_oleh'];
}