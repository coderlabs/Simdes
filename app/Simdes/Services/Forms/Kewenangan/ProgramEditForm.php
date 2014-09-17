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
 * Class ProgramForm
 *
 * @package Simdes\Services\Forms\Kewenangan
 */
class ProgramEditForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'bidang_id'     => 'required|max:11',
        'program'       => 'required|max:255',
        'kode_rekening' => 'required|max:20',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'bidang_id',
            'program',
            'user_id',
            'organisasi_id',
            'kode_rekening'
        ]);
    }
}