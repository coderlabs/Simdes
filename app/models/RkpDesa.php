<?php

Class RkpDesa extends Eloquent{
	protected $table ='tb_rkpdesa';
	public $timestamps = false;
	protected $fillable = ['rpjmdesa_id','user_id','kegiatan_id','program_id','tahun','lokasi','sasaran','waktu','status','satuan','pagu_anggaran','sumber_dana_id','is_rka','is_dpa','indikator_masukan_id','indikator_keluaran_id','indikator_hasil_id','indikator_dampak_id','indikator_manfaat_id'];

	public function user(){
		return $this->belongsTo('User','user_id');
	}

	public function kegiatan(){
		return $this->belongsTo('Kegiatan','kegiatan_id');
	}

	public function program(){
		return $this->belongsTo('Program','program_id');
	}

	public function sumberDana(){
		return $this->belongsTo('SumberDana','sumber_dana_id');
	}

	public function rpjmdesa(){
		return $this->belongsTo('Rpjmdesa','rpjmdesa_id');
	}

	public function masukan(){
		return $this->belongsTo('IndikatorMasukan','indikator_masukan_id');
	}	

	public function keluaran(){
		return $this->belongsTo('IndikatorKeluaran','indikator_keluaran_id');
	}	

	public function hasil(){
		return $this->belongsTo('IndikatorHasil','indikator_hasil_id');
	}	

	public function manfaat(){
		return $this->belongsTo('IndikatorManfaat','indikator_manfaat_id');
	}	

	public function dampak(){
		return $this->belongsTo('IndikatorDampak','indikator_dampak_id');
	}	

}