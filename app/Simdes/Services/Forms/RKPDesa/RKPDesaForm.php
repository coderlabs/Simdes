<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/16/2014
 * Time: 17:52
 */

namespace Simdes\Services\Forms\RKPDesa;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class RKPDesaForm
 *
 * @package Simdes\Services\Forms\RKPDesa
 */
class RKPDesaForm extends AbstractForm
{

    /**
     * @var array
     */
    protected $rules = [
        'program_id'      => 'required|integer',
        'kegiatan_id'     => 'required|integer',
        'rpjmdesa_id'     => 'required|integer',
        'tahun'           => 'required|integer',
        'lokasi'          => 'required',
        'sasaran'         => 'required',
        'target'          => 'required',
        'waktu'           => 'required',
        'status'          => 'required',
        'tujuan'          => 'required',
        'pejabat_desa_id' => 'required',
        'pagu_anggaran'   => 'required',
        'sumber_dana_id'  => 'required|integer'
    ];

    /**
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'user_id',
            'organisasi_id',
            'program_id',
            'kegiatan_id',
            'kegiatan',
            'rpjmdesa_id',
            'tahun',
            'lokasi',
            'sasaran',
            'tujuan',
            'target',
            'pejabat_desa_id',
            'waktu',
            'status',
            'pagu_anggaran',
            'sumber_dana_id',
            'sumber_dana',
            'indikator_masukan_id',
            'indikator_keluaran_id',
            'indikator_hasil_id',
            'indikator_manfaat_id'
        ]);
    }
}