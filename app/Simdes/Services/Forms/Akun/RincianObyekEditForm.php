<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 18:20
 */

namespace Simdes\Services\Forms\Akun;
use Simdes\Services\Forms\AbstractForm;


/**
 * Class RincianObyekEditForm
 *
 * @package Simdes\Services\Forms\Akun
 */
class RincianObyekEditForm extends AbstractForm{
    /**
     * siapkan validasi
     *
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required',
        'rincian_obyek' => 'required',
        'obyek_id'      => 'required|integer'
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