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
 * Class DasarHukum
 * @package Simdes\Models\Perdes
 */
class DasarHukum extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_perdes_dasar_hukum';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = [
        'jenis_peraturan',
        'pengundangan',
        'dasar_hukum',
        'perdes_id',
        'user_id',
        'organisasi_id'
    ];

    public function judul()
    {
        return $this->belongsTo('Simdes\Models\Perdes\Judul', 'perdes_id');
    }
}