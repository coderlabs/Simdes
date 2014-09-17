<?php

Class Kab extends Eloquent{
	protected $table ='tb_kab';
	public $timestamps = false;
	protected $fillable = ['kab'];
    protected $appends = array('provinsi');

    public function getProvinsiAttribute($value)
    {
        $provinsiId = substr($this->id, 0, 2);
        $provinsi = Prov::find($provinsiId);
        return $provinsi;
    }
}