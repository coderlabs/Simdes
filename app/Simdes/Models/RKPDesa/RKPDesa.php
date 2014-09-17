<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 10:48
 */

namespace Simdes\Models\RKPDesa;


use Illuminate\Database\Eloquent\Model;

/**
 * Class RKPDesa
 *
 * @package Simdes\Models\RKPDesa
 */
class RKPDesa extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_rkpdesa';
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'organisasi_id', 'program_id', 'kegiatan_id', 'kegiatan', 'rpjmdesa_id', 'tahun', 'lokasi', 'sasaran', 'waktu', 'satuan', 'status', 'pagu_anggaran', 'sumber_dana_id', 'sumber_dana', 'indikator_masukan_id', 'indikator_keluaran_id', 'indikator_hasil_id', 'indikator_manfaat_id','target','tujuan'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Simdes\Models\User\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function masukan()
    {
        return $this->belongsTo('Simdes\Models\RKPDesa\IndikatorMasukan', 'indikator_masukan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function keluaran()
    {
        return $this->belongsTo('Simdes\Models\RKPDesa\IndikatorKeluaran', 'indikator_keluaran_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hasil()
    {
        return $this->belongsTo('Simdes\Models\RKPDesa\IndikatorHasil', 'indikator_hasil_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manfaat()
    {
        return $this->belongsTo('Simdes\Models\RKPDesa\IndikatorManfaat', 'indikator_manfaat_id');
    }

    public function pejabatDesa()
    {
        return $this->belongsTo('Simdes\Models\Pejabat\PejabatDesa', 'pejabat_desa_id');
    }
}