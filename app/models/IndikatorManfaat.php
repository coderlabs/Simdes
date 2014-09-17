<?php

Class IndikatorManfaat extends Eloquent{
	protected $table ='tb_indikator_manfaat';
	public $timestamps = false;
	protected $fillable = ['rkpdesa_id','tolok_ukur','target','satuan'];

	public function rkpdesa(){
		return $this->belongsTo('RkpDesa','rkpdesa_id');
	}
}