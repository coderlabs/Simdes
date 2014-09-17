<?php
    /**
     * Email: edicyber@gmail.com
     * User: Edi Santoso
     * Date: 5/18/2014
     * Time: 11:13
     */

    namespace Simdes\Repositories\Eloquent\RKPDesa;

    use Simdes\Models\RKPDesa\IndikatorKeluaran;
    use Simdes\Repositories\Eloquent\AbstractRepository;
    use Simdes\Repositories\RKPDesa\IndikatorKeluaranRepositoryInterface;
    use Simdes\Services\Forms\RKPDesa\IndikatorKeluaranEditForm;

    /**
     * Class IndikatorKeluaranRepository
     *
     * @package Simdes\Repositories\Eloquent\RKPDesa
     */
    class IndikatorKeluaranRepository extends AbstractRepository implements IndikatorKeluaranRepositoryInterface
    {

        /**
         * @param IndikatorKeluaran $keluaran
         */
        public function __construct(IndikatorKeluaran $keluaran)
        {
            $this->model = $keluaran;
        }

        /**
         * @param IndikatorKeluaran $keluaran
         * @param array             $data
         *
         * @return IndikatorKeluaran
         */
        public function update(IndikatorKeluaran $keluaran, array $data)
        {
            $keluaran->tolok_ukur = e($data['tolok_ukur']);
            $keluaran->target = e($data['target']);
            $keluaran->satuan = e($data['satuan']);
            $keluaran->user_id = e($data['user_id']);
            $keluaran->save();

            return $keluaran;
        }

        /**
         * @return IndikatorKeluaranEditForm
         */
        public function getEditForm()
        {
            return new IndikatorKeluaranEditForm();
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