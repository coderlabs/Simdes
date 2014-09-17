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

/**
 * Class KegiatanForm
 * @package Simdes\Services\Forms\Kewenangan
 */
class KegiatanForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'program_id'    => 'required|max:11',
        'kegiatan'      => 'required|max:255',
        'kode_rekening' => 'required|max:20',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'program_id',
            'kegiatan',
            'kode_rekening'
        ]);
    }
}