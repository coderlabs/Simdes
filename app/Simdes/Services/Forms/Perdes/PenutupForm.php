<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:35
 */

namespace Simdes\Services\Forms\Perdes;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class PenutupForm
 * @package Simdes\Services\Forms\Perdes
 */
class PenutupForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'tempat'               => 'required',
        'tanggal'              => 'required',
        'pengundangan'         => 'required',
        'tanggal_pengundangan' => 'required',
        'nomor'                => 'required',
        'tahun'                => 'required',
        'perdes_id'            => 'required'
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'tempat',
            'tanggal',
            'nomor',
            'tahun',
            'pengundangan',
            'tanggal_pengundangan',
            'perdes_id',
            'user_id',
            'organisasi_id',
        ]);
    }
}