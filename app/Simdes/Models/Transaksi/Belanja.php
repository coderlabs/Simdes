<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/9/2014
 * Time: 09:15
 */

namespace Simdes\Models\Transaksi;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Belanja
 * @package Simdes\Models\Transaksi
 */
class Belanja extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $guarded = ['id'];
    /**
     * @var string
     */
    protected $table = 'tb_transaksi_belanja';
    /**
     * @var array
     */
    protected $fillable = [
        'belanja_id',
        'no_bukti',
        'tanggal',
        'pejabat_desa_id',
        'jumlah',
        'ssh_id',
        'kode_barang',
        'penerima',
        'item',
        'harga',
        'user_id',
        'organisasi_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belanja()
    {
        return $this->belongsTo('Simdes\Models\Belanja\Belanja', 'belanja_id');
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