<?php

Class RincianObyek extends Eloquent{
	protected $table ='tb_rinc_obyek';
	public $timestamps = false;
	protected $fillable = ['kd_rekening','rincian_obyek','id_obyek'];

	public function obyek(){
		return $this->belongsTo('Obyek','id_obyek');
	}
}