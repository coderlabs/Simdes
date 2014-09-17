<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 15:47
 */

namespace Simdes\Models\Log;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Jenis
 *
 * @package Simdes\Models
 */
class Log extends Model {

    /**
     * @var string
     */
    protected $table = 'tb_user_log';

    /**
     * @var string
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['user_id','nama','fungsi','deskripsi','created_at','organisasi_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('Simdes\Models\User\User','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisasi(){
        return $this->belongsTo('Simdes\Models\Organisasi\Organisasi','organisasi_id');
    }
} 