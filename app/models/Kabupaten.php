<?php

Class Kabupaten extends Eloquent{
	protected $table ='tb_master_kab';
	public $timestamps = false;
	protected $fillable = ['kode_prov','kode_kab','kab','status','seo','zona_waktu'];

	public function provinsi(){
		return $this->belongsTo('Provinsi','kode_prov');
	}

}