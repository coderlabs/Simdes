<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 15:52
 */

namespace Simdes\Services\Forms\User;


use Simdes\Services\Forms\AbstractForm;

class KonfirmasiForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'email'           => 'required|email',
        'activation_code' => 'required'
    ];

    /**
     * Siapkan input data
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'email',
            'activation_code'
        ]);
    }
}