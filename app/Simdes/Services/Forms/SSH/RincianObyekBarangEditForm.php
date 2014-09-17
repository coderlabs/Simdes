<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:16
 */

namespace Simdes\Services\Forms\SSH;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class RincianObyekBarangEditForm
 *
 * @package Simdes\Services\Forms\ssh
 */
class RincianObyekBarangEditForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'kode_rekening' => 'required',
        'obyek_id'      => 'required',
        'rincian_obyek' => 'required',
        'spesifikasi'   => 'required',
        'harga'         => 'required',
        'satuan'        => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'kode_rekening',
            'obyek_id',
            'rincian_obyek',
            'spesifikasi',
            'harga',
            'satuan',
        ]);
    }

}