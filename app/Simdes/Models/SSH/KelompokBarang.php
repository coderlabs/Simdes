<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 08:45
 */

namespace Simdes\Models\SSH;


use Illuminate\Database\Eloquent\Model;

/**
 * Class KelompokBarang
 *
 * @package Simdes\Models\ssh
 */
class KelompokBarang extends Model
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
    protected $table = 'tb_barang_kelompok';
    /**
     * @var array
     */
    protected $fillable = ['kode_rekening', 'kelas_id', 'kelompok'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo('Simdes\Models\SSH\KelasBarang', 'kelas_id');
    }

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(kelompok)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }

}