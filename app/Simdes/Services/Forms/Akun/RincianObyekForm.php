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
 * Class RincianObyekForm
 *
 * @package Simdes\Services\Forms\Akun
 */
class RincianObyekForm extends AbstractForm{
    /**
     * siapkan validasi
     *
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required',
        'rincian_obyek' => 'required',
        'obyek_id'      => 'required'
    ];

    /**
     * siapkan data
     *
     * @return array
     */
    public function getInputData(){
        return array_only($this->inputData,['kode_rekening','rincian_obyek','obyek_id','user_id','organisasi_id']);
    }

} 