<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/31/2014
 * Time: 18:07
 */

namespace Simdes\Models\Pejabat;


use Illuminate\Database\Eloquent\Model;

/**
 * Class PejabatDesa
 * @package Simdes\Models\Pejabat
 */
class PejabatDesa extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_pejabat_desa';
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'nomor_sk',
        'judul',
        'pejabat',
        'tanggal_sk',
        'organisasi_id',
        'fungsi'
    ];

}