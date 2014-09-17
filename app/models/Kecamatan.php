<?php

Class Kecamatan extends Eloquent{
	protected $table ='tb_master_kec';
	public $timestamps = false;
	protected $fillable = ['kode_kab','kode_kec','kec'];

	public function provinsi(){
		return $this->belongsTo('Kabupaten','kode_kab');
	}
}