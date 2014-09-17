<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/14
 * Time: 1:24 PM
 */

namespace Simdes\Models\Akun;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Kelompok
 *
 * @package Simdes\Models\Akun
 */
class Kelompok extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_akun_kelompok_1';
    /**
     * The table associated with the model.
     *
     * @var array
     */
    protected $fillable = ['akun_id', 'kode_rekening', 'kelompok'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akun()
    {
        return $this->belongsTo('Simdes\Models\Akun\Akun', 'akun_id');
    }

    /**
     * Implementasi FullTextSearch
     *
     * @param $query
     * @param $q
     * @return mixed
     */
    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(kelompok)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}