<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:17
 */

namespace Simdes\Models\Perdes;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Judul
 * @package Simdes\Models\Perdes
 */
class Judul extends Model{

    /**
     * @var string
     */
    protected $table = 'tb_perdes_judul';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'jenis',
        'judul',
        'nomor',
        'user_id',
        'organisasi_id'
    ];

    public function konsideran(){
        return $this->hasMany('Simdes\Models\Perdes\Konsideran','perdes_id');
    }

    public function dasarHukum(){
        return $this->hasMany('Simdes\Models\Perdes\DasarHukum','perdes_id');
    }

    public function batangTubuh(){
        return $this->hasMany('Simdes\Models\Perdes\BatangTubuh','perdes_id');
    }

    public function penutup(){
        return $this->hasMany('Simdes\Models\Perdes\Penutup','perdes_id');
    }

    public function materi(){
        return $this->hasMany('Simdes\Models\Perdes\MateriPokok','perdes_id');
    }

    public function poin(){
        return $this->hasMany('Simdes\Models\Perdes\MateriPokokPoin','perdes_id');
    }

    public function pendapatan(){
        return $this->hasMany('Simdes\Models\Pendapatan\Pendapatan','organisasi_id','organisasi_id');
    }

    public function belanja(){
        return $this->hasMany('Simdes\Models\Belanja\Belanja','organisasi_id','organisasi_id');
    }

    public function pembiayaan(){
        return $this->hasMany('Simdes\Models\Pembiayaan\Pembiayaan','organisasi_id','organisasi_id');
    }
}