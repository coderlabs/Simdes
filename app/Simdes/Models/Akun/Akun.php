<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/14
 * Time: 1:10 PM
 */

namespace Simdes\Models\Akun;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Akun
 *
 * @package Simdes\Models\Akun
 */
class Akun extends Model{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_akun';


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var array
     */
    protected $fillable = ['kd_rekening','akun'];
} 