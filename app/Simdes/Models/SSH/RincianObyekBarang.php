<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 08:53
 */

namespace Simdes\Models\SSH;


use Illuminate\Database\Eloquent\Model;

/**
 * Class RincianObyekBarang
 *
 * @package Simdes\Models\ssh
 */
class RincianObyekBarang extends Model
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
     * @var array
     */
    protected $table = 'tb_barang_rincian_obyek';
    /**
     * @var array
     */
    protected $fillable = ['kode_rekening', 'obyek_id', 'rincian_obyek', 'spesifikasi', 'satuan', 'harga'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function obyek()
    {
        return $this->belongsTo('Simdes\Models\SSH\ObyekBarang', 'obyek_id');
    }

    /**
     * @param $query
     * @param $q
     * @return mixed
     */
    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(rincian_obyek,satuan,harga)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }

}