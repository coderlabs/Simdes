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
 * Class BelanjaForm
 *
 * @package Simdes\Services\Forms\Belanja
 */
class BelanjaHistoryForm extends AbstractForm
{
    /**
     * @var array
     */
    protected $rules = [
        'januari'   => 'required',
        'februari'  => 'required',
        'maret'     => 'required',
        'april'     => 'required',
        'mei'       => 'required',
        'juni'      => 'required',
        'juli'      => 'required',
        'agustus'   => 'required',
        'september' => 'required',
        'oktober'   => 'required',
        'november'  => 'required',
        'desember'  => 'required',
    ];

    /**
     * Menpersiapkan data untuk jadi input
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'januari',
            'februari',
            'maret',
            'april',
            'mei',
            'juni',
            'juli',
            'agustus',
            'september',
            'oktober',
            'november',
            'desember',
        ]);
    }

}