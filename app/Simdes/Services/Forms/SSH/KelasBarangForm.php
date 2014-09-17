<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 08:59
 */

namespace Simdes\Services\Forms\SSH;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class KelasBarangForm
 *
 * @package Simdes\Services\Forms\ssh
 */
class KelasBarangForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required|max:50',
        'kelas'         => 'required|max:255'
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'kode_rekening',
            'kelas',
        ]);
    }
}