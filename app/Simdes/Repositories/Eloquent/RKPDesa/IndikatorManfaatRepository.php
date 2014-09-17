<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 11:21
     */

    namespace Simdes\Repositories\Eloquent\RKPDesa;


    use Simdes\Models\RKPDesa\IndikatorManfaat;
    use Simdes\Repositories\Eloquent\AbstractRepository;
    use Simdes\Repositories\RKPDesa\IndikatorManfaatRepositoryInterface;
    use Simdes\Services\Forms\RKPDesa\IndikatorManfaatEditForm;

    /**
     * Class IndikatorManfaatRepository
     *
     * @package Simdes\Repositories\Eloquent\RKPDesa
     */
    class IndikatorManfaatRepository extends AbstractRepository implements IndikatorManfaatRepositoryInterface
    {

        /**
         * @param IndikatorManfaat $manfaat
         */
        public function __construct(IndikatorManfaat $manfaat)
        {
            $this->model = $manfaat;
        }

        /**
         * @param IndikatorManfaat $manfaat
         * @param array            $data
         *
         * @return IndikatorManfaat
         */
        public function update(IndikatorManfaat $manfaat, array $data)
        {
            $manfaat->tolok_ukur = e($data['tolok_ukur']);
            $manfaat->target = e($data['target']);
            $manfaat->satuan = e($data['satuan']);
            $manfaat->user_id = e($data['user_id']);
            $manfaat->save();

            return $manfaat;
        }

        /**
         * @return IndikatorManfaatEditForm
         */
        public function getEditForm()
        {
            return new IndikatorManfaatEditForm();
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
    }