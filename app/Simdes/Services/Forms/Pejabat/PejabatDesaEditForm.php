<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/2/2014
 * Time: 19:04
 */

namespace Simdes\Services\Forms\Pejabat;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class PejabatDesaEditForm
 * @package Simdes\Services\Forms\Pejabat
 */
class PejabatDesaEditForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'nama'       => 'required',
        'jabatan'    => 'required',
        'fungsi'     => 'required',
        'pejabat'    => 'required',
        'tanggal_sk' => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'nama',
            'jabatan',
            'nomer_sk',
            'judul',
            'nip',
            'fungsi',
            'pejabat',
            'tanggal_sk',
            'organisasi_id',
            'fungsi',
        ]);
    }
}