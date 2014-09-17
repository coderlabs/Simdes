<?php

Class Organisasi extends Eloquent{
	protected $table ='tb_organisasi';
	public $timestamps = false;
	protected $fillable = ['kode_desa','desa','kode_kec','kec','kode_kab','kab','alamat','logo','no_telepon','email','fax','kode_prov','prov'];

}