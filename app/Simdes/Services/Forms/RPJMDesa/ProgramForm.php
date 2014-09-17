<?php
    /**
     * Created by PhpStorm.
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/13/2014
     * Time: 13:18
     */

    namespace Simdes\Services\Forms\RPJMDesa;


    use Simdes\Services\Forms\AbstractForm;

    /**
     * Class ProgramForm
     *
     * @package Simdes\Services\Forms\RPJMDesa
     */
    class ProgramForm extends AbstractForm
    {
        /**
         * @var array
         */
        protected $rules = [
            'masalah_id'      => 'required|integer',
            'rpjmdesa_id'     => 'required|integer',
            'program_id'      => 'required|integer',
            'lokasi'          => 'required',
            'sasaran'         => 'required',
            'waktu'           => 'required',
            'pagu_anggaran'   => 'required',
            'target'          => 'required',
            'sifat'           => 'required',
            'tujuan'          => 'required',
            'sumber_dana_id'  => 'required|integer',
            'pejabat_desa_id' => 'required|integer'
        ];

        /**
         * @return array
         */
        public function getInputData()
        {
            return array_only($this->inputData, [
                'masalah_id',
                'target',
                'sifat',
                'tujuan',
                'program_id',
                'program',
                'lokasi',
                'sasaran',
                'waktu',
                'pagu_anggaran',
                'sumber_dana_id',
                'sumber_dana',
                'rpjmdesa_id',
                'penanggung_jawab',
                'pejabat_desa_id'
            ]);
        }
    }