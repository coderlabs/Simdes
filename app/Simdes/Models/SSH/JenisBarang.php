<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 08:48
 */

namespace Simdes\Models\SSH;


use Illuminate\Database\Eloquent\Model;

/**
 * Class JenisBarang
 *
 * @package Simdes\Models\ssh
 */
class JenisBarang extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var string
     */
    protected $table = 'tb_barang_jenis';
    /**
     * @var array
     */
    protected $fillable = ['kelompok_id', 'kode_rekening', 'jenis'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelompok()
    {
        return $this->belongsTo('Simdes\Models\SSH\KelompokBarang', 'kelompok_id');
    }

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(jenis)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }

}