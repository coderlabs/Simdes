<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:34
 */

namespace Simdes\Services\Forms\Perdes;


use Simdes\Services\Forms\AbstractForm;

class KetentuanForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'perdes_id'   => 'required',
        'judul'       => 'required',
        'pasal'       => 'required',
        'pendahuluan' => 'required',
        'poin'        => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'perdes_id',
            'judul',
            'pasal',
            'pendahuluan',
            'poin',
            'user_id',
            'organisasi_id'
        ]);
    }
}