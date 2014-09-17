<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/18/2014
 * Time: 09:06
 */

namespace Simdes\Repositories\Eloquent\Kewenangan;

use Simdes\Models\Kewenangan\Kegiatan;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Services\Forms\Kewenangan\KegiatanEditForm;
use Simdes\Services\Forms\Kewenangan\KegiatanForm;

/**
 * Class KegiatanRepository
 * @package Simdes\Repositories\Eloquent\Kewenangan
 */
class KegiatanRepository extends AbstractRepository implements KegiatanRepositoryInterface
{

    /**
     * @param Kegiatan $kegiatan
     */
    public function __construct(Kegiatan $kegiatan)
    {
        $this->model = $kegiatan;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->orderBy('id')
            ->FullTextSearch($term)
            ->whereIn('organisasi_id', [$organisasi_id, 43])
            ->with('program')
            ->paginate(10);
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $kegiatan = $this->getNew();

        $kegiatan->program_id = e(trim($data['program_id']));
        $kegiatan->kegiatan = e(trim($data['kegiatan']));
        $kegiatan->kode_rekening = e(trim($data['kode_rekening']));
        $kegiatan->user_id = e($data['user_id']);
        $kegiatan->organisasi_id = e($data['organisasi_id']);
        $kegiatan->save();

        return $kegiatan;

    }

    /**
     * @param Kegiatan $kegiatan
     * @param array $data
     * @return Kegiatan
     */
    public function update(Kegiatan $kegiatan, array $data)
    {
        if ($kegiatan->organisasi_id == $data['organisasi_id']) {
            $kegiatan->kegiatan = e(trim($data['kegiatan']));
            $kegiatan->kode_rekening = e(trim($data['kode_rekening']));
            $kegiatan->user_id = e($data['user_id']);
            $kegiatan->save();

            return [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data telah berhasil di update.',
            ];
        } else {
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf Anda tidak diperkenankan untuk mengedit default kegiatan. Silahkan tambahkan kegiatan.',
            ];
        }

    }

    /**
     * @param $id
     * @param $organisasi_id
     * @return array
     */
    public function delete($id, $organisasi_id)
    {
        $kegiatan = $this->findById($id);

        // cek apakah program_id yang bersangkutan sudah dipakai oleh relasi kegiatan

        // cek apakah organisasi_id dari user adalah backoffice
        // untuk sementara ditandai dengan organsiasi_id = 43
        if ($kegiatan->organisasi_id == $organisasi_id) {
            $kegiatan->delete();
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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findById($id)
    {
        return $this->model->with('program')->find($id);
    }

    /**
     * @return KegiatanForm
     */
    public function getCreationForm()
    {
        return new KegiatanForm();
    }

    /**
     * @return KegiatanEditForm
     */
    public function getEditForm()
    {
        return new KegiatanEditForm();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getStringKegiatan($id)
    {
        $data = $this->findById($id);

        return $data->kegiatan;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getList($organisasi_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->all(['id', 'kegiatan']);
    }

    /**
     * Menampilkan data dropdown kegiatan
     * dikases oleh RKPDesa
     *
     * @param $program_id
     * @return mixed
     */
    public function getListKegiatan($program_id, $organisasi_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->where('program_id', '=', $program_id)
            ->get(['id', 'kegiatan']);
    }

    /**
     * Method dipakai untuk mengecek apakah data dengan
     * $program_id yg bersangkutan dipakai oleh relasi
     * dikegiatan, untuk dapat menghapus data tsb
     *
     * @param $program_id
     * @return mixed
     */
    public function findIsExists($program_id)
    {
        return $this->model
            ->where('program_id', '=', $program_id)
            ->get();
    }
} 