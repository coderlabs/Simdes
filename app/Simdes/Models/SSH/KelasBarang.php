<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 06:52
 */

namespace Simdes\Models\SSH;


use Illuminate\Database\Eloquent\Model;

/**
 * Class KelasBarang
 *
 * @package Simdes\Models\ssh
 */
class KelasBarang extends Model
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
    protected $table = 'tb_barang_kelas';
    /**
     * @var array
     */
    protected $fillable = ['kode_rekening', 'kelas'];

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(kelas)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }
}