<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 15:52
 */

namespace Simdes\Services\Forms\User;


use Simdes\Services\Forms\AbstractForm;

class ResetPasswordForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'password' => 'required',

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
            'remember_token',
            'password',
            'organisasi_id'
        ]);
    }
}