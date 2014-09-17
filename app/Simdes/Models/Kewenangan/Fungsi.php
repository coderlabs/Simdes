<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/28/2014
 * Time: 21:39
 */

namespace Simdes\Models\Kewenangan;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Kewenangan
 * @package Simdes\Models\Kewenangan
 */
class Fungsi extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_kewenangan_fungsi';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * @var array
     */
    protected $fillable = [
        'kewenangan_id',
        'kode_rekening',
        'fungsi',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kewenangan()
    {
        return $this->belongsTo('Simdes\Models\Kewenangan\Kewenangan', 'kewenangan_id');
    }

    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(fungsi)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}