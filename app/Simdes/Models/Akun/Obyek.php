<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 15:53
 */

namespace Simdes\Models\Akun;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Obyek
 *
 * @package Simdes\Models
 */
class Obyek extends Model
{

    /**
     * @var string
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_akun_obyek';
    /**
     * @var array
     */
    protected $fillable = ['kode_rekening', 'jenis_id', 'obyek', 'regulasi', 'tanggal', 'pengundangan'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis()
    {
        return $this->belongsTo('Simdes\Models\Akun\Jenis', 'jenis_id');
    }

    public function scopeFullTextSearch($query,$q) {
        return empty($q) ? $query : $query->whereRaw("MATCH(obyek,regulasi,pengundangan)AGAINST(? IN BOOLEAN MODE)",[$q]);
    }
}