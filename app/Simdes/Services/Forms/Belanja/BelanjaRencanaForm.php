<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/19/2014
 * Time: 07:54
 */

namespace Simdes\Services\Forms\Belanja;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class BelanjaRencanaForm
 * @package Simdes\Services\Forms\Belanja
 */
class BelanjaRencanaForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'belanja_id'  => 'required',
        'uraian'      => 'required',
        'ssh_id'      => 'required',
        'kegiatan'    => 'required',
        'jumlah_item' => 'required',
        'jumlah'      => 'required',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'user_id',
            'belanja_id',
            'uraian',
            'ssh_id',
            'kegiatan',
            'jumlah_item',
            'jumlah',
            'organisasi_id',
        ]);
    }

}