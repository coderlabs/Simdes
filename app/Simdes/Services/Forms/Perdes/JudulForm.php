<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 19:32
 */

namespace Simdes\Services\Forms\Perdes;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class JudulForm
 * @package Simdes\Services\Forms\Perdes
 */
class JudulForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'judul'                => 'required',
        'jenis'                => 'required',
        'nomor'                => 'required',
        'tempat'               => 'required',
        'tanggal'              => 'required|date',
        'pengundangan'         => 'required',
        'tanggal_pengundangan' => 'required|date',
        'tahun'                => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'judul',
            'jenis',
            'nomor',
            'tempat',
            'tanggal',
            'pengundangan',
            'tanggal_pengundangan',
            'tahun',
            'user_id',
            'organisasi_id',
        ]);
    }
}