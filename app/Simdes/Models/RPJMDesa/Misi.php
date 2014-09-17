<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:05
 */

namespace Simdes\Models\RPJMDesa;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Misi
 *
 * @package Simdes\Models\RPJMDesa
 */
class Misi extends Model{
    /**
     * @var string
     */
    protected $table = 'tb_rpjm_misi';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['rpjmdesa_id','misi','user_id'];

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(misi)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }
} 