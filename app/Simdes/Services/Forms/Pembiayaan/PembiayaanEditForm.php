<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 19:40
 */

namespace Simdes\Services\Forms\Pembiayaan;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class PembiayaanEditForm
 *
 * @package Simdes\Services\Forms\Pembiayaan
 */
class PembiayaanEditForm extends AbstractForm{

    /**
     * @var array
     */
    protected $rules = [
        'tahun'        => 'required',
        'kelompok_id'  => 'required|integer',
        'volume_1'     => 'required',
        'satuan_1'     => 'required',
        'satuan_harga' => 'required|numeric'
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'tahun', 'kelompok_id', 'jenis_id', 'obyek_id', 'rincian_obyek_id', 'volume_1', 'volume_2', 'volume_3', 'satuan_1', 'satuan_2', 'satuan_3', 'satuan_harga'
        ]);
    }

} 