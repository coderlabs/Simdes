<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:15
 */

namespace Simdes\Models\Kewenangan;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Program
 *
 * @package Simdes\Models\Kewenangan
 */
class Program extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_kewenangan_program';
    /**
     * @var array
     */
    protected $fillable = [
        'kode_rekening',
        'bidang_id',
        'program'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bidang(){
        return $this->belongsTo('Simdes\Models\Kewenangan\Bidang','bidang_id');
    }

    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(program)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}