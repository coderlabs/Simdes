<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/7/2014
 * Time: 05:38
 */

namespace Simdes\Models\Transaksi;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Pendapatan
 * @package Simdes\Models\Transaksi
 */
class Pendapatan extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_transaksi_pendapatan';
    /**
     * @var array
     */
    protected $fillable = [
        'pendapatan_id',
        'no_bukti',
        'tanggal',
        'penerima',
        'no_bku',
        'jumlah',
        'user_id',
        'pejabat_desa_id',
        'organisasi_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pendapatan()
    {
        return $this->belongsTo('Simdes\Models\Pendapatan\Pendapatan','pendapatan_id');
    }

    /**
     * Scope function pencarian fulltext Search
     *
     * @param $query
     * @param $q
     * @return mixed
     */
    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(uraian)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }

    /**
     * Scope function berdasarkan organisasi_id
     * @param $query
     * @param $organisasi_id
     * @return mixed
     */
    public function scopeOrganisasi($query,$organisasi_id)
    {
        return $query->whereOrganisasi_id($organisasi_id);
    }
} 