<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 11:04
     */

    namespace Simdes\Services\Forms\RKPDesa;


    use Simdes\Services\Forms\AbstractForm;

    /**
     * Class IndikatorHasilEditForm
     *
     * @package Simdes\Services\Forms\RKPDesa
     */
    class IndikatorHasilEditForm extends AbstractForm
    {

        /**
         * @var array
         */
        protected $rules = [
            'tolok_ukur' => 'required',
            'target'     => 'required',
            'satuan'     => 'required'
        ];

        /**
         * @return array
         */
        public function getInputData()
        {
            return array_only($this->inputData, [
                'tolok_ukur',
                'target',
                'satuan',
                'user_id'
            ]);
        }

    }