<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:34
 */

namespace Simdes\Services\Forms\Perdes;


use Simdes\Services\Forms\AbstractForm;

class MateriPokokPoinForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'materi_pokok_id' => 'required',
        'poin'            => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'materi_pokok_id',
            'poin',
            'user_id',
            'organisasi_id'
        ]);
    }
}