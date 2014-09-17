<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/14
 * Time: 9:30 AM
 */

namespace Simdes\Services\Forms\Pendapatan;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class PendapatanEditForm
 *
 * @package Simdes\Services\Forms\Pendapatan
 */
class PendapatanEditForm extends AbstractForm{

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
     * Menpersiapkan data untuk jadi input
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'tahun', 'kelompok_id','jenis_id','obyek_id','rincian_obyek_id','volume_1','volume_2','volume_3','satuan_1','satuan_2','satuan_3','satuan_harga'
        ]);
    }
} 