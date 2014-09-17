<?php

Class TimAnggaran extends Eloquent{
	protected $table ='tb_tim_anggaran';
	public $timestamps = false;
	protected $fillable = ['jabatan','sk_nomer','tentang','tanggal','dikeluarkan_oleh'];
}