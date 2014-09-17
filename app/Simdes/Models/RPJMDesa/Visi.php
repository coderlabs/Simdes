<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:01
 */

namespace Simdes\Models\RPJMDesa;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Visi
 *
 * @package Simdes\Models\RPJMDesa
 */
class Visi extends Model{
    /**
     * @var string
     */
    protected $table = 'tb_rpjm_visi';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['visi','id_rpjmdesa','user_id','rpjmdesa_id'];

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(visi)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }
} 