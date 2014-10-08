<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:17
 */

namespace Simdes\Models\RPJMDesa;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Program
 *
 * @package Simdes\Models\RPJMDesa
 */
class Program extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_rpjm_program';
    /**
     * @var array
     */
    protected $fillable = [
        'masalah_id',
        'program_id',
        'masalah',
        'program',
        'lokasi',
        'sasaran',
        'waktu',
        'pagu_anggaran',
        'sumber_dana_id',
        'penanggung_jawab',
        'sumber_dana',
        'user_id',
        'rpjmdesa_id',
        'target',
        'sifat',
        'tujuan',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo('Simdes\Models\Kewenangan\Program', 'program_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function masalah()
    {
        return $this->belongsTo('Simdes\Models\RPJMDesa\Masalah', 'masalah_id');
    }

    public function pejabat()
    {
        return $this->belongsTo('Simdes\Models\Pejabat\PejabatDesa', 'pejabat_desa_id');
    }

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(program,target,sifat,tujuan,sumber_dana,lokasi,sasaran)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }
}