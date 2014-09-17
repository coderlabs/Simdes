<?php

Class Rpjmdesa extends Eloquent{
	protected $table ='tb_rpjmdesa';
	public $timestamps = false;
	protected $fillable = ['id_visi','id_misi','id_program','id_sumber_dana','id_pejabat_desa','sasaran','waktu','status','pagu_anggaran'];

	public function visi(){
		return $this->belongsTo('Visi','id_visi');
	}

	public function program(){
		return $this->belongsTo('Program','id_program');
	}

	public function misi()
    {
        return $this->hasMany('Misi');
    }

    public function masalah()
    {
        return $this->hasMany('Masalah');
    }

    public function potensi()
    {
        return $this->hasMany('Potensi','rpjmdesa_id');
    }

    public function pemetaan()
    {
        return $this->hasMany('Pemetaan','rpjmdesa_id');
    }

    public function rpjmprogram()
    {
        return $this->hasMany('RpjmProgram','rpjmdesa_id');
    }

}