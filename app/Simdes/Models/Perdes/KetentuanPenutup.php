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
 * Class KetentuanPenutup
 * @package Simdes\Models\Perdes
 */
class KetentuanPenutup extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_perdes_ketentuan_penutup';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = [
        'perdes_id',
        'judul',
        'pasal',
        'pendahuluan',
        'poin',
        'user_id',
        'organisasi_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function judul()
    {
        return $this->belongsTo('Simdes\Models\Perdes\Judul', 'perdes_id');
    }

} 