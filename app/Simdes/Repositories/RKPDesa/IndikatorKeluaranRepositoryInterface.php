<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 10:56
     */

    namespace Simdes\Repositories\RKPDesa;


    use Simdes\Models\RKPDesa\IndikatorKeluaran;

    /**
     * Interface IndikatorKeluaranRepositoryInterface
     *
     * @package Simdes\Repositories\RKPDesa
     */
    interface IndikatorKeluaranRepositoryInterface
    {

        /**
         * @param IndikatorKeluaran $keluaran
         * @param array             $data
         *
         * @return mixed
         */
        public function update(IndikatorKeluaran $keluaran, array $data);

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
        public function findByFilter($id, $organisasi_id);
    }