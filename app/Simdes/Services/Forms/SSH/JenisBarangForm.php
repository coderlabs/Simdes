<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:08
 */

namespace Simdes\Services\Forms\SSH;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class JenisBarangForm
 *
 * @package Simdes\Services\Forms\ssh
 */
class JenisBarangForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'kelompok_id'   => 'required|max:50',
        'kode_rekening' => 'required|max:50',
        'jenis'         => 'required|max:255'
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'kelompok_id',
            'kode_rekening',
            'jenis',
        ]);
    }

}