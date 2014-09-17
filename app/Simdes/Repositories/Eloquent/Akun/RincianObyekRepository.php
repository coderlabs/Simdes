<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:31
 */

namespace Simdes\Repositories\Eloquent\Akun;

use Simdes\Models\Akun\RincianObyek;
use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Services\Forms\Akun\RincianObyekEditForm;
use Simdes\Services\Forms\Akun\RincianObyekForm;

/**
 * Class RincianObyekRepository
 *
 * @package Simdes\Repositories\Eloquent\Akun
 */
class RincianObyekRepository extends AbstractRepository implements RincianObyekRepositoryInterface
{

    /**
     * @param RincianObyek $rincianObyek
     */
    public function __construct(RincianObyek $rincianObyek)
    {
        $this->model = $rincianObyek;
    }

    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        $rincianObyek = $this->model->orderBy('id')
            ->FullTextSearch($term)
            ->whereIn('organisasi_id', [$organisasi_id, 43])
            ->with('obyek')
            ->paginate(10);

        return $rincianObyek;
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $rincianObyek = $this->getNew();

        $rincianObyek->kode_rekening = e($data['kode_rekening']);
        $rincianObyek->obyek_id = e($data['obyek_id']);
        $rincianObyek->rincian_obyek = e($data['rincian_obyek']);
        $rincianObyek->user_id = e($data['user_id']);
        $rincianObyek->organisasi_id = e($data['organisasi_id']);
        $rincianObyek->save();

        return $rincianObyek;
    }

    /**
     * @param RincianObyek $rincianObyek
     * @param array $data
     *
     * @return RincianObyek
     */
    public function update(RincianObyek $rincianObyek, array $data)
    {
        // cek apakah organisasi_id sama, jika sama lanjutkan proses update
        // jika tidak sama kembalikan return berupa konfirmasi warning
        if ($rincianObyek->organisasi_id == $data['organisasi_id']) {
            $rincianObyek->kode_rekening = e($data['kode_rekening']);
            $rincianObyek->obyek_id = e($data['obyek_id']);
            $rincianObyek->rincian_obyek = e($data['rincian_obyek']);
            $rincianObyek->user_id = e($data['user_id']);
            $rincianObyek->save();

            return [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data telah berhasil di update.',
            ];
        } else {
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf Anda tidak diperkenankan untuk mengedit default rincian obyek APBDesa. Silahkan tambahkan rincian obyek.',
            ];
        }
    }

    /**
     * @param $id
     * @param $organisasi_id
     * @return array
     */
    public function delete($id,$organisasi_id)
    {
        $rincian_obyek = $this->findById($id);

        // cek apakah program_id yang bersangkutan sudah dipakai oleh relasi kegiatan

        // cek apakah organisasi_id dari user adalah backoffice
        // untuk sementara ditandai dengan organsiasi_id = 43
        if ($rincian_obyek->organisasi_id == $organisasi_id) {
            $rincian_obyek->delete();
            return [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data berhasil dihapus.',
            ];
        } else {
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf Anda tidak diperkenankan untuk menghapus default kegiatan. Silahkan tambahkan kegiatan.',
            ];
        }
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findbyId($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $obyek_id
     *
     * @return mixed
     */
    public function findByIdObyek($obyek_id)
    {
        return $this->model->where('obyek_id', '=', $obyek_id)->get(['id', 'rincian_obyek']);
    }

    /**
     * @return RincianObyekForm
     */
    public function getCreationForm()
    {
        return new RincianObyekForm();
    }

    /**
     *
     * @return RincianObyekEditForm
     */
    public function getEditForm()
    {
        return new RincianObyekEditForm();
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id)
    {
        return $this->model->where('id', '=', $id)
            ->whereIn('organisasi_id', [$organisasi_id, 43])
            ->first();
    }

    /**
     * Method dipakai untuk mengecek apakah data dengan
     * $obyek_id yg bersangkutan dipakai oleh relasi
     * dirincian obyek, untuk diperbolehkan hps data
     *
     * @param $obyek_id
     * @return mixed
     */
    public function findIsExists($obyek_id)
    {
        return $this->model
            ->where('obyek_id', '=', $obyek_id)
            ->get();
    }
}