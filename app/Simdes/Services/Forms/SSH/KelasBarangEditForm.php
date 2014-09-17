<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:03
 */

namespace Simdes\Services\Forms\SSH;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class KelasBarangEditForm
 *
 * @package Simdes\Services\Forms\ssh
 */
class KelasBarangEditForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required',
        'kelas'         => 'required'
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