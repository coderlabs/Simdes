<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/19/2014
 * Time: 07:57
 */

namespace Simdes\Services\Forms\Belanja;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class BelanjaEditForm
 *
 * @package Simdes\Services\Forms\Belanja
 */
class BelanjaEditForm extends AbstractForm
{
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
            'user_id',
            'tahun',
            'kelompok_id',
            'jenis_id',
            'obyek_id',
            'rincian_obyek_id',
            'volume_1',
            'volume_2',
            'volume_3',
            'satuan_1',
            'satuan_2',
            'satuan_3',
            'jumlah',
            'belanja',
            'satuan_harga',
            'organisasi_id',
            'kegiatan_id',
            'kegiatan',
            'rkpdesa_id',
            'pagu_anggaran',
            'jenis_belanja'
        ]);
    }

}