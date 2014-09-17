<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 18:18
 */

namespace Simdes\Services\Forms\Akun;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class JenisForm
 *
 * @package Simdes\Services\Forms\Akun
 */
class JenisForm extends AbstractForm{
    /**
     * @var array
     */
    protected  $rules = [
        'kode_rekening' => 'required',
        'jenis'         => 'required',
        'kelompok_id'   => 'required',
        'referensi'     => 'required',

    ];

    /**
     * siapkan data
     *
     * @return array
     */
    public function getInputData(){
        return array_only($this->inputData,['kode_rekening','kelompok_id','jenis','referensi','organisasi_id','user_id']);
    }
}