<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/17/2014
 * Time: 22:05
 */

namespace Simdes\Models\Kewenangan;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Kegiatan
 * @package Simdes\Models\Kewenangan
 */
class Kegiatan extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'tb_kewenangan_kegiatan';

    /**
     * @var array
     */
    protected $fillable = [
        'program_id',
        'kode_rekening',
        'kegiatan',
        'program_id',
        'organisasi_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo('Simdes\Models\Kewenangan\Program', 'program_id');
    }

    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(kegiatan)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}