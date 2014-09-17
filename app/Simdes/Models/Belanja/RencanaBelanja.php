<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 10:39
 */

namespace Simdes\Models\Belanja;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Belanja
 *
 * @package Simdes\Models\Belanja
 */
class RencanaBelanja extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_rencana_belanja';
    /**
     * @var array
     */
    protected $fillable = [
        'belanja_id',
        'uraian',
        'ssh_id',
        'kegiatan',
        'jumlah_item',
        'jumlah',
        'user_id',
        'organisasi_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelompok()
    {
        return $this->belongsTo('Simdes\Models\Akun\Kelompok', 'kelompok_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis()
    {
        return $this->belongsTo('Simdes\Models\Akun\Jenis', 'jenis_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function obyek()
    {
        return $this->belongsTo('Simdes\Models\Akun\Obyek', 'obyek_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rincianObyek()
    {
        return $this->belongsTo('Simdes\Models\Akun\RincianObyek', 'rincian_obyek_id');
    }
}