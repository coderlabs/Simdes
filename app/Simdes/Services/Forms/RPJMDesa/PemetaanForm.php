<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 13:16
 */

namespace Simdes\Services\Forms\RPJMDesa;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class PemetaanForm
 *
 * @package Simdes\Services\Forms\RPJMDesa
 */
class PemetaanForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'masalah_id'  => 'required|integer',
        'rpjmdesa_id' => 'required|integer',
        'pemetaan_1'  => 'required|numeric|max:20',
        'pemetaan_2'  => 'required|numeric|max:20',
        'pemetaan_3'  => 'required|numeric|max:20',
        'pemetaan_4'  => 'required|numeric|max:20',
        'pemetaan_5'  => 'required|numeric|max:20',
        'peringkat'   => 'required'
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'masalah_id',
            'pemetaan_1',
            'pemetaan_2',
            'pemetaan_3',
            'pemetaan_4',
            'pemetaan_5',
            'jumlah',
            'user_id',
            'rpjmdesa_id'
        ]);
    }
}