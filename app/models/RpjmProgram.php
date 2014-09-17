<?php

Class RpjmProgram extends Eloquent{
	protected $table ='tb_rpjm_program';
	public $timestamps = false;
	protected $fillable = ['masalah_id','rpjmdesa_id','program_id','program','lokasi','sasaran','waktu','pagu_anggaran','sumber_dana_id','sumber_dana','pejabat_desa_id','penanggung_jawab'];

}