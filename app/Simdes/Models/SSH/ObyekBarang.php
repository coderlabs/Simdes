<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 08:50
 */

namespace Simdes\Models\SSH;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ObyekBarang
 *
 * @package Simdes\Models\ssh
 */
class ObyekBarang extends Model
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
    protected $table = 'tb_barang_obyek';
    /**
     * @var array
     */
    protected $fillable = ['jenis_id', 'kode_rekening', 'obyek'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis()
    {
        return $this->belongsTo('Simdes\Models\SSH\JenisBarang', 'jenis_id');
    }

    /**
     * @param $query
     * @param $q
     * @return mixed
     */
    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(obyek)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }

}