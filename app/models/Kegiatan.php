<?php

Class Kegiatan extends Eloquent{
	protected $table ='tb_kegiatan';
	public $timestamps = false;
	protected $fillable = ['kode_kegiatan','id_program','kegiatan'];

	public function program(){
		return $this->belongsTo('Program','id_program');
	}
}