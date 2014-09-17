<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:34
 */

namespace Simdes\Services\Forms\Perdes;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class DasarHukumEditForm
 * @package Simdes\Services\Forms\Perdes
 */
class DasarHukumEditForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'pengundangan' => 'required',
        'dasar_hukum'  => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'pengundangan',
            'dasar_hukum',
            'perdes_id',
            'user_id',
            'organisasi_id',
        ]);
    }

} 