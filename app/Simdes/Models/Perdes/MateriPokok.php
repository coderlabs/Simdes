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
 * Class Mekanisme
 * @package Simdes\Models\Perdes
 */
class MateriPokok extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_perdes_materi_pokok';
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

    public function scopeOrganisasi($query,$organisasi_id)
    {
        return $query->whereOrganisasi_id($organisasi_id);
    }

    public function scopePerdes($query,$perdes_id)
    {
        return $query->wherePerdes_id($perdes_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function judul()
    {
        return $this->belongsTo('Simdes\Models\Perdes\Judul', 'perdes_id');
    }

    public function poin(){
        return $this->hasMany('Simdes\Models\Perdes\MateriPokokPoin','materi_pokok_id');
    }
}