<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:33
 */

namespace Simdes\Services\Forms\Kewenangan;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class KewenanganEditForm
 * @package Simdes\Services\Forms\Kewenangan
 */
class KewenanganEditForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required',
        'kewenangan'    => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'kode_rekening',
            'kewenangan',
            'user_id',
        ]);
    }
}