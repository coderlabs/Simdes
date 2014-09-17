<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:20
 */

namespace Simdes\Models\Perdes;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Penutup
 * @package Simdes\Models\Perdes
 */
class Penutup extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_perdes_penutup';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = [
        'tempat',
        'tanggal',
        'pengundangan',
        'tanggal_pengundangan',
        'user_id',
        'organisasi_id'
    ];

    public function judul(){
        return $this->belongsTo('Simdes\Models\Perdes\Judul','perdes_id');

    }

} 