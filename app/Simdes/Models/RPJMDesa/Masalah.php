<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:07
 */

namespace Simdes\Models\RPJMDesa;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Masalah
 *
 * @package Simdes\Models\RPJMDesa
 */
class Masalah extends Model{
    /**
     * @var string
     */
    protected $table = 'tb_rpjm_masalah';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['rpjmdesa_id','pemetaan_id','masalah','user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function potensi()
    {
        return $this->belongsTo('Simdes\Models\RPJMDesa\Potensi','potensi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemetaan()
    {
        return $this->belongsTo('Simdes\Models\RPJMDesa\Pemetaan','pemetaan_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->hasMany('RpjmProgram','program_id');
    }

    public function scopeFullTextSearch($query, $q)
    {
        return empty($q) ? $query : $query->whereRaw("MATCH(masalah)AGAINST(? IN BOOLEAN MODE)", [$q]);
    }

} 