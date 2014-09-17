<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/28/2014
 * Time: 21:39
 */

namespace Simdes\Models\Kewenangan;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Kewenangan
 * @package Simdes\Models\Kewenangan
 */
class Bidang extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_kewenangan_bidang'; //todo : ganti tbl dari 'tb_bidang'
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = [
        'kewenangan_id',
        'kode_rekening',
        'bidang',
        'regulasi',
        'tanggal',
        'pengundangan',
        'user_id',
        'organisasi_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fungsi()
    {
        return $this->belongsTo('Simdes\Models\Kewenangan\Fungsi', 'fungsi_id');
    }

    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(bidang)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}