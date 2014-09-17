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
     * Class MisiEditForm
     *
     * @package Simdes\Services\Forms\RPJMDesa
     */
    class MisiEditForm extends AbstractForm
    {
        /**
         * @var array
         */
        protected $rules = [
            'misi'        => 'required'
        ];

        /**
         * @return array
         */
        public function getInputData()
        {
            return array_only($this->inputData, [
                'misi','rpjmdesa_id','user_id'
            ]);
        }
    }