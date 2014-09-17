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

class BidangForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'fungsi_id' => 'required|max:11',
        'kode_rekening' => 'required|max:20',
        'bidang'        => 'required|max:255',
        'regulasi'      => 'required|max:255',
        'tanggal'       => 'required',
        'pengundangan'  => 'required|max:255',

    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'fungsi_id',
            'kode_rekening',
            'bidang',
            'regulasi',
            'tanggal',
            'pengundangan',
            'user_id',
            'organisasi_id',
        ]);
    }
}