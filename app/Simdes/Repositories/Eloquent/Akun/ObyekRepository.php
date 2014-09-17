<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:28
 */

namespace Simdes\Repositories\Eloquent\Akun;


use Simdes\Models\Akun\Obyek;
use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Services\Forms\Akun\ObyekEditForm;
use Simdes\Services\Forms\Akun\ObyekForm;

/**
 * Class ObyekRepository
 *
 * @package Simdes\Repositories\Eloquent\Akun
 */
class ObyekRepository extends AbstractRepository implements ObyekRepositoryInterface
{

    /**
     * @var RincianObyekRepositoryInterface
     */
    private $rincianObyek;

    /**
     * @param Obyek $obyek
     * @param RincianObyekRepositoryInterface $rincianObyek
     */
    public function __construct(Obyek $obyek,RincianObyekRepositoryInterface $rincianObyek)
    {
        $this->model = $obyek;
        $this->rincianObyek = $rincianObyek;
    }

    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        $obyek = $this->model->orderBy('id')
            ->FullTextSearch($term)
            ->whereIn('organisasi_id', [$organisasi_id, 43])
            ->with('jenis')
            ->paginate(10);

        return $obyek;
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $obyek = $this->getNew();

        $obyek->kode_rekening = e($data['kode_rekening']);
        $obyek->jenis_id = e($data['jenis_id']);
        $obyek->obyek = e($data['obyek']);
        $obyek->regulasi = e($data['regulasi']);
        $obyek->tanggal = e($data['tanggal']);
        $obyek->pengundangan = e($data['pengundangan']);
        $obyek->user_id = e($data['user_id']);
        $obyek->organisasi_id = e($data['organisasi_id']);
        $obyek->save();

        return $obyek;
    }

    /**
     * @param Obyek $obyek
     * @param array $data
     *
     * @return Obyek
     */
    public function update(Obyek $obyek, array $data)
    {
        // cek apakah organisasi_id sama, jika sama lanjutkan proses update
        // jika tidak sama kembalikan return berupa konfirmasi warning
        if ($obyek->organisasi_id == $data['organisasi_id']) {
            $obyek->kode_rekening = e($data['kode_rekening']);
            $obyek->jenis_id = e($data['jenis_id']);
            $obyek->obyek = e($data['obyek']);
            $obyek->regulasi = e($data['regulasi']);
            $obyek->tanggal = e($data['tanggal']);
            $obyek->pengundangan = e($data['pengundangan']);
            $obyek->user_id = e($data['user_id']);
            $obyek->save();

            return [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data telah berhasil di update.',
            ];
        } else {
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf Anda tidak diperkenankan untuk mengedit default obyek APBDesa. Silahkan tambahkan obyek.',
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
        $obyek = $this->findById($id);

        // cek apakah program_id yang bersangkutan sudah dipakai oleh relasi kegiatan
        $result = $this->cekForDelete($obyek->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi dirincian obyek, silahkan untuk menghapus data yang ada dirincian obyek terlebih dahulu.'
            ];
            // cek apakah organisasi_id dari user adalah backoffice
            // untuk sementara ditandai dengan organsiasi_id = 43
        } elseif ($obyek->organisasi_id == $organisasi_id) {
        $obyek->delete();
            return [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data berhasil dihapus.',
            ];
        } else {
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf Anda tidak diperkenankan untuk menghapus default program. Silahkan tambahkan program.',
            ];
        }

    }

    /**
     * @param $obyek_id
     * @return mixed
     */
    public function cekForDelete($obyek_id)
    {
        return $this->rincianObyek->findIsExists($obyek_id);
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
     * @param $jenis_id
     *
     * @return mixed
     */
    public function findByIdJenis($jenis_id)
    {
        return $this->model->where('jenis_id', '=', $jenis_id)->get(['id', 'obyek']);
    }

    /**
     * @return ObyekForm
     */
    public function getCreationForm()
    {
        return new ObyekForm();
    }

    /**
     *
     * @return ObyekEditForm
     */
    public function getEditForm()
    {
        return new ObyekEditForm();
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
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($organisasi_id)
    {
        return $this->model
            ->whereIn('organisasi_id', [$organisasi_id, 43])
            ->get(['id', 'obyek','kode_rekening']);
    }

    /**
     * @param $jenis_id
     * @return mixed
     */
    public function findIsExists($jenis_id)
    {
        return $this->model
            ->where('jenis_id', '=', $jenis_id)
            ->get();
    }
}