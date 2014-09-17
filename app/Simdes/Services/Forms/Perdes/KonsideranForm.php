<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:33
 */

namespace Simdes\Services\Forms\Perdes;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class KonsideranForm
 * @package Simdes\Services\Forms\Perdes
 */
class KonsideranForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'konsideran' => 'required',
        'perdes_id'  => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'konsideran',
            'perdes_id',
            'user_id',
            'organisasi_id',
        ]);
    }

} 