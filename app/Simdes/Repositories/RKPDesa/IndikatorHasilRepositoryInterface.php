<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 10:57
     */

    namespace Simdes\Repositories\RKPDesa;


    use Simdes\Models\RKPDesa\IndikatorHasil;

    /**
     * Interface IndikatorHasilRepositoryInterface
     *
     * @package Simdes\Repositories\RKPDesa
     */
    interface IndikatorHasilRepositoryInterface
    {

        /**
         * @param IndikatorHasil $hasil
         * @param array          $data
         *
         * @return mixed
         */
        public function update(IndikatorHasil $hasil, array $data);

        /**
         * @return mixed
         */
        public function getEditForm();

        /**
         * @param $id
         * @param $organisasi_id
         *
         * @return mixed
         */
        public function findByFilter($id,$organisasi_id);
    }