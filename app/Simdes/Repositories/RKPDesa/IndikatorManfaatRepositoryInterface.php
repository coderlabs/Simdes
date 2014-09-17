<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 10:58
     */

    namespace Simdes\Repositories\RKPDesa;


    use Simdes\Models\RKPDesa\IndikatorManfaat;

    /**
     * Interface IndikatorManfaatRepositoryInterface
     *
     * @package Simdes\Repositories\RKPDesa
     */
    interface IndikatorManfaatRepositoryInterface
    {

        /**
         * @param IndikatorManfaat $manfaat
         * @param array            $data
         *
         * @return mixed
         */
        public function update(IndikatorManfaat $manfaat,array $data);

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