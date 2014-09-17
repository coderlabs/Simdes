<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:15
 */

namespace Simdes\Models\RPJMDesa;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Potensi
 *
 * @package Simdes\Models\RPJMDesa
 */
class Potensi extends Model{
    /**
     * @var string
     */
    protected $table = 'tb_rpjm_potensi';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['masalah_id','rpjmdesa_id','potensi','user_id'];

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(potensi)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }
} 