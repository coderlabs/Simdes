<?php

Class Pemetaan extends Eloquent{
	protected $table ='tb_rpjm_pemetaan';
	public $timestamps = false;
	protected $fillable = ['masalah_id','rpjmdesa_id','pemetaan_1','pemetaan_2','pemetaan_3','pemetaan_4','pemetaan_5','jumlah','peringkat'];

	public function masalah()
    {
        return $this->belongsTo('Masalah','masalah_id');
    }
}