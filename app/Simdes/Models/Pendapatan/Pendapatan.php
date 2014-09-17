<?php

namespace Simdes\Models\Pendapatan;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pendapatan
 *
 * @package Simdes\Models\Pendapatan
 */
class Pendapatan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_pendapatan';

    /**
     * Disable timestamps
     *
     * @var datetime
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var array
     */
	protected $fillable = ['user_id','pendapatan','tahun','kelompok_id','kelompok','jenis_id','jenis','obyek_id','obyek','rincian_obyek_id','volume_1','volume_2','volume_3','satuan_1','satuan_2','saatuan_3','jumlah','sisa_anggaran'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelompok(){
        return $this->belongsTo('Simdes\Models\Akun\Kelompok','kelompok_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis(){
        return $this->belongsTo('Simdes\Models\Akun\Jenis','jenis_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function obyek(){
        return $this->belongsTo('Simdes\Models\Akun\Obyek','obyek_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rincianObyek(){
        return $this->belongsTo('Simdes\Models\Akun\RincianObyek','rincian_obyek_id');
    }
    
}