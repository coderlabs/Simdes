<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 15:52
 */

namespace Simdes\Services\Forms\User;


use Simdes\Services\Forms\AbstractForm;

class GantiPasswordForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'email'         => 'required|email',
        'password'      => 'required|max:255|min:3',
        'password_baru' => 'required|max:255|min:3'
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
            'password',
            'password_baru'
        ]);
    }
}