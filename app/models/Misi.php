<?php

Class Misi extends Eloquent{
	protected $table ='tb_rpjm_misi';
	public $timestamps = false;
	protected $fillable = ['misi','id_rpjm_desa'];

	public function rpjmdesa(){
		return $this->belongsTo('Rpjmdesa','id_rpjmdesa');
	}
}