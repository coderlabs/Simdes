<?php
    /**
     * Created by PhpStorm.
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/13/2014
     * Time: 13:16
     */

    namespace Simdes\Services\Forms\RPJMDesa;


    use Simdes\Services\Forms\AbstractForm;

    /**
     * Class MasalahForm
     *
     * @package Simdes\Services\Forms\RPJMDesa
     */
    class MasalahForm extends AbstractForm
    {
        /**
         * @var array
         */
        protected $rules = [
            'masalah'     => 'required',
            'rpjmdesa_id' => 'required|integer'
        ];

        /**
         * @return array
         */
        public function getInputData()
        {
            return array_only($this->inputData, [
                'masalah', 'rpjmdesa_id', 'user_id'
            ]);
        }
    }