<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/9/2014
 * Time: 09:18
 */

namespace Simdes\Services\Forms\Transaksi;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class BelanjaEditForm
 * @package Simdes\Services\Forms\Transaksi
 */
class BelanjaEditForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'belanja_id'      => 'required',
        'no_bukti'        => 'required',
        'tanggal'         => 'required',
        'pejabat_desa_id' => 'required',
        'ssh_id'          => 'required',
        'kode_barang'     => 'required',
        'item'            => 'required',
        'harga'           => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'belanja_id',
            'belanja',
            'no_bukti',
            'tanggal',
            'pejabat_desa_id',
            'jumlah',
            'ssh_id',
            'barang',
            'kode_barang',
            'penerima',
            'item',
            'harga',
            'user_id',
            'organisasi_id'
        ]);
    }
} 