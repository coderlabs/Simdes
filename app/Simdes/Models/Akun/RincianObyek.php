<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 15:56
 */

namespace Simdes\Models\Akun;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RincianObyek
 *
 * @package Simdes\Models
 */
class RincianObyek extends Model {
    /**
     * @var string
     */
    protected $table = 'tb_akun_rincian_obyek';

    /**
     * @var string
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['kode_rekening','obyek_id','rincian_obyek'];

    public function obyek(){
        return $this->belongsTo('Simdes\Models\Akun\Obyek','obyek_id');

    }
    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(rincian_obyek)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}