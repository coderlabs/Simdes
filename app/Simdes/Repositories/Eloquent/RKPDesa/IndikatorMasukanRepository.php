<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 13:23
     */

    namespace Simdes\Repositories\Eloquent\RKPDesa;


    use Simdes\Models\RKPDesa\IndikatorMasukan;
    use Simdes\Repositories\Eloquent\AbstractRepository;
    use Simdes\Repositories\RKPDesa\IndikatorMasukanRepositoryInterface;
    use Simdes\Services\Forms\RKPDesa\IndikatorMasukanEditForm;

    /**
     * Class IndikatorMasukanRepository
     *
     * @package Simdes\Repositories\Eloquent\RKPDesa
     */
    class IndikatorMasukanRepository extends AbstractRepository implements IndikatorMasukanRepositoryInterface
    {

        /**
         * @param IndikatorMasukan $masukan
         */
        public function __construct(IndikatorMasukan $masukan)
        {
            $this->model = $masukan;
        }

        /**
         * @param $id
         * @param $organisasi_id
         *
         * @return mixed
         */
        public function findByFilter($id, $organisasi_id)
        {
            return $this->model->where('id', '=', $id)->where('organisasi_id', '=', $organisasi_id)->first();
        }

        /**
         * @return IndikatorMasukanEditForm
         */
        public function getEditForm()
        {
            return new IndikatorMasukanEditForm();
        }


        /**
         * @param IndikatorMasukan $masukan
         * @param array            $data
         *
         * @return IndikatorMasukan
         */
        public function update(IndikatorMasukan $masukan, array $data)
        {
            $masukan->tolok_ukur = e($data['tolok_ukur']);
            $masukan->target = e($data['target']);
            $masukan->satuan = e($data['satuan']);
            $masukan->user_id = e($data['user_id']);
            $masukan->save();

            return $masukan;
        }

    }