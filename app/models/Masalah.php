<?php

Class Masalah extends Eloquent{
	protected $table ='tb_rpjm_masalah';
	public $timestamps = false;
	protected $fillable = ['masalah','rpjmdesa_id'];

	public function pemetaan(){
		return $this->belongsTo('Pemetaan','pemetaan_id');
	}
}