<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 15:47
 */

namespace Simdes\Models\Akun;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Jenis
 *
 * @package Simdes\Models
 */
class Jenis extends Model
{

    /**
     * @var string
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_akun_jenis';
    /**
     * @var array
     */
    protected $fillable = ['kode_rekening', 'kelompok_id', 'jenis', 'referensi'];

    public function kelompok()
    {
        return $this->belongsTo('Simdes\Models\Akun\Kelompok', 'kelompok_id');
    }

    // todo implementasi fulltext search
    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(jenis)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }
}