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
 * Class BidangEditForm
 * @package Simdes\Services\Forms\Kewenangan
 */
class FungsiEditForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'kewenangan_id' => 'required|max:11',
        'kode_rekening' => 'required|max:20',
        'fungsi'        => 'required|max:255',
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'kewenangan_id',
            'kode_rekening',
            'fungsi',
        ]);
    }
}