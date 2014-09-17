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
class PendapatanHistoryForm extends AbstractForm
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