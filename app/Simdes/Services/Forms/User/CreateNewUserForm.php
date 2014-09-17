<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 15:52
 */

namespace Simdes\Services\Forms\User;


use Simdes\Services\Forms\AbstractForm;

class CreateNewUserForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:4',
        'name'      => 'required',
        'is_fungsi' => 'required|numeric|max:10',
        'is_active' => 'required|numeric|max:2',
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
            'is_fungsi',
            'is_active',
            'organisasi_id'
        ]);
    }
}