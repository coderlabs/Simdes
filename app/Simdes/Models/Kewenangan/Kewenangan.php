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
class Kewenangan extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_kewenangan_1';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = [
        'kode_rekening',
        'kewenangan',
        'user_id',
        'organisasi_id',
    ];

    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(kewenangan)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}