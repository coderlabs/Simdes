<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:11
 */

namespace Simdes\Services\Forms\SSH;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class ObyekBarangForm
 *
 * @package Simdes\Services\Forms\ssh
 */
class ObyekBarangForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required|max:50',
        'jenis_id'      => 'required',
        'obyek'         => 'required|max:255',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'kode_rekening',
            'jenis_id',
            'obyek',
        ]);
    }

}