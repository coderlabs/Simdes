<?php

Class PejabatDesa extends Eloquent{
	protected $table ='tb_pejabat_desa';
	public $timestamps = false;
	protected $fillable = ['nama','jabatan','nomer_sk','judul','tanggal_sk','pejabat'];

}