<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 10:56
 */

namespace Simdes\Models\RPJMDesa;


use Illuminate\Database\Eloquent\Model;

/**
 * Class RPJMDesa
 *
 * @package Simdes\Models\RPJMDesa
 */
class RPJMDesa extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'tb_rpjmdesa';
    /**
     * @var array
     */
    protected $fillable = ['visi_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visi()
    {
        return $this->belongsTo('Simdes\Models\RPJMDesa\Visi', 'visi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function misi()
    {
        return $this->hasMany('Simdes\Models\RPJMDesa\Misi', 'rpjmdesa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function masalah()
    {
        return $this->hasMany('Simdes\Models\RPJMDesa\Masalah', 'rpjmdesa_id');
    }


}