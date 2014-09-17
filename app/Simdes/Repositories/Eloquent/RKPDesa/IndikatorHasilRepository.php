<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 11:18
     */

    namespace Simdes\Repositories\Eloquent\RKPDesa;


    use Simdes\Models\RKPDesa\IndikatorHasil;
    use Simdes\Repositories\Eloquent\AbstractRepository;
    use Simdes\Repositories\RKPDesa\IndikatorHasilRepositoryInterface;
    use Simdes\Services\Forms\RKPDesa\IndikatorHasilEditForm;

    /**
     * Class IndikatorHasilRepository
     *
     * @package Simdes\Repositories\Eloquent\RKPDesa
     */
    class IndikatorHasilRepository extends AbstractRepository implements IndikatorHasilRepositoryInterface
    {

        /**
         * @param IndikatorHasil $hasil
         */
        public function __construct(IndikatorHasil $hasil)
        {
            $this->model = $hasil;
        }

        /**
         * @param IndikatorHasil $hasil
         * @param array          $data
         *
         * @return IndikatorHasil
         */
        public function update(IndikatorHasil $hasil, array $data)
        {
            $hasil->tolok_ukur = e($data['tolok_ukur']);
            $hasil->target = e($data['target']);
            $hasil->satuan = e($data['satuan']);
            $hasil->user_id = e($data['user_id']);
            $hasil->save();

            return $hasil;
        }

        /**
         * @return IndikatorHasilEditForm
         */
        public function getEditForm()
        {
            return new IndikatorHasilEditForm();
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