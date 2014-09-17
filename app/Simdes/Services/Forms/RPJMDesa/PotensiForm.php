<?php
    /**
     * Created by PhpStorm.
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/13/2014
     * Time: 13:17
     */

    namespace Simdes\Services\Forms\RPJMDesa;


    use Simdes\Services\Forms\AbstractForm;

    /**
     * Class PotensiForm
     *
     * @package Simdes\Services\Forms\RPJMDesa
     */
    class PotensiForm extends AbstractForm
    {
        /**
         * @var array
         */
        protected $rules = [
            'masalah_id'  => 'required|integer',
            'potensi'     => 'required',
            'rpjmdesa_id' => 'required|integer'
        ];

        /**
         * @return array
         */
        public function getInputData()
        {
            return array_only($this->inputData, [
                'masalah_id',
                'rpjmdesa_id',
                'potensi',
                'user_id'
            ]);
        }
    }