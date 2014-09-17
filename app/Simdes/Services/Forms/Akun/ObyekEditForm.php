<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 18:19
 */

namespace Simdes\Services\Forms\Akun;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class ObyekEditForm
 *
 * @package Simdes\Services\Forms\Akun
 */
class ObyekEditForm extends AbstractForm{
    /**
     * siapkan validasi
     *
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required',
        'obyek'         => 'required',
        'jenis_id'      => 'required',
        'regulasi'      => 'required',
        'tanggal'       => 'required',
        'pengundangan'  => 'required'
    ];

    /**
     * siapkan data
     *
     * @return array
     */
    public function getInputData(){
        return array_only($this->inputData,['kode_rekening','obyek','jenis_id','regulasi','tanggal','pengundangan','user_id','organisasi_id']);
    }
} 