<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 15:52
 */

namespace Simdes\Services\Forms\User;


use Simdes\Services\Forms\AbstractForm;

class UserEditForm extends AbstractForm
{
    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'name',
            'fungsi',
            'jabatan',
            'organisasi',
            'organisasi_id'
        ]);
    }

} 