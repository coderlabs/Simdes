<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 15:52
 */

namespace Simdes\Services\Forms\User;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class RegistrationForm
 *
 * @package Simdes\Services\Forms\User
 */
class RegistrationForm extends AbstractForm
{

    /**
     * Validasi data
     *
     * @var array
     */
    protected $rules = [
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|min:4|max:255',
        'name'       => 'required|max:255',
        'organisasi' => 'required'
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
            'name',
            'organisasi'
        ]);
    }

}