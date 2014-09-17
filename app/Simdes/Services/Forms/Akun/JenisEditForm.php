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
 * Class JenisEditForm
 *
 * @package Simdes\Services\Forms\Akun
 */
class JenisEditForm extends AbstractForm{
    /**
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required',
        'kelompok_id'   => 'required|integer',
        'referensi'     => 'required',
        'jenis'         => 'required'
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