<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:11
 */

namespace Simdes\Models\RPJMDesa;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Pemetaan
 *
 * @package Simdes\Models\RPJMDesa
 */
class Pemetaan extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_rpjm_pemetaan';
    /**
     * @var array
     */
    protected $fillable = ['masalah_id', 'rpjmdesa_id', 'pemetaan_1', 'pemetaan_2', 'pemetaan_3', 'pemetaan_4', 'pemetaan_5', 'jumlah'];

    public function masalah()
    {
        return $this->belongsTo('Simdes\Models\RPJMDesa\Masalah', 'masalah_id');
    }
} 