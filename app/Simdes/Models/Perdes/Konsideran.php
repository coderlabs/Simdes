<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:19
 */

namespace Simdes\Models\Perdes;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Konsideran
 * @package Simdes\Models\Perdes
 */
class Konsideran extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_perdes_konsideran';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = [
        'konsideran',
        'perdes_id',
        'user_id',
        'organisasi_id',
    ];

    public function judul(){
        return $this->belongsTo('Simdes\Models\Perdes\Judul','perdes_id');
    }
}