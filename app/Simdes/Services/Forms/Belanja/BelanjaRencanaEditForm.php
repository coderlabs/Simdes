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
 * Class BelanjaRencanaEditForm
 * @package Simdes\Services\Forms\Belanja
 */
class BelanjaRencanaEditForm extends AbstractForm
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
            'uraian',
            'ssh_id',
            'kegiatan',
            'jumlah_item',
            'jumlah',
        ]);
    }

}