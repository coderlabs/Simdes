<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:24
 */

namespace Simdes\Repositories\Eloquent\Kewenangan;


use Simdes\Models\Kewenangan\Program;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Repositories\Kewenangan\ProgramRepositoryInterface;
use Simdes\Services\Forms\Kewenangan\ProgramEditForm;
use Simdes\Services\Forms\Kewenangan\ProgramForm;

/**
 * Class ProgramRepository
 *
 * @package Simdes\Repositories\Eloquent\Kewenangan
 */
class ProgramRepository extends AbstractRepository implements ProgramRepositoryInterface
{
    /**
     * @var KegiatanRepositoryInterface
     */
    private $kegiatan;

    /**
     * @param Program $program
     */
    public function __construct(Program $program, KegiatanRepositoryInterface $kegiatan)
    {
        $this->model = $program;
        $this->kegiatan = $kegiatan;
    }

    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        // menampilkan program yang diinput oleh backoffice user organisasi
        // juga bisa menginput program tapi tidak bisa menghapus program
        // atau edit progam yang telah diinputkan oleh user backoffice
        return $this->model
            ->whereIn('organisasi_id', [$organisasi_id, 43])
            ->FullTextSearch($term)
            ->with('bidang')
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $program = $this->getNew();

        $program->bidang_id = e($data['bidang_id']);
        $program->program = e($data['program']);
        $program->kode_rekening = e($data['kode_rekening']);
        $program->user_id = e($data['user_id']);
        $program->organisasi_id = e($data['organisasi_id']);
        $program->save();

        return $program;
    }

    /**
     * @param Program $program
     * @param array $data
     *
     * @return Program
     */
    public function update(Program $program, array $data)
    {
        // cek apakah organisasi_id sama, jika sama lanjutkan proses update
        // jika tidak sama kembalikan return berupa konfirmasi warning
        if ($program->organisasi_id == $data['organisasi_id']) {
            $program->bidang_id = e($data['bidang_id']);
            $program->program = e($data['program']);
            $program->kode_rekening = e($data['kode_rekening']);
            $program->user_id = e($data['user_id']);
            $program->save();

            return [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data telah berhasil di update.',
            ];
        } else {
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf Anda tidak diperkenankan untuk mengedit default program. Silahkan tambahkan program.',
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
        $program = $this->findById($id);

        // cek apakah program_id yang bersangkutan sudah dipakai oleh relasi kegiatan
        $result = $this->cekForDelete($program->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi diprogram, silahkan untuk menghapus data yang ada diprogram terlebih dahulu.'
            ];
            // cek apakah organisasi_id dari user adalah backoffice
            // untuk sementara ditandai dengan organsiasi_id = 43
        } elseif ($program->organisasi_id == $organisasi_id) {
            $program->delete();
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
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static
     */
    public function findById($id)
    {
        return $this->model->with('bidang')->find($id);
    }

    /**
     * @param $program_id
     * @return mixed
     */
    public function cekForDelete($program_id)
    {
        return $this->kegiatan->findIsExists($program_id);
    }

    /**
     * @return ProgramForm
     */
    public function getCreationForm()
    {
        return new ProgramForm();
    }

    /**
     * @return ProgramEditForm
     */
    public function getEditForm()
    {
        return new ProgramEditForm();
    }

    /**
     * @param $bidang_id
     *
     * @return mixed
     */
    public function findByIdBidang($bidang_id)
    {
        return $this->model->where('bidang_id', '=', $bidang_id)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getList($bidang_id, $organisasi_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->orWhere('organisasi_id', '=', 43)
            ->where('bidang_id', '=', $bidang_id)
            ->get(['id', 'program', 'kode_rekening']);
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getListProgram($organisasi_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->orWhere('organisasi_id', '=', 43)
            ->get(['id', 'program', 'kode_rekening']);
    }

    /**
     * Method dipakai untuk mengecek apakah data dengan
     * $bidang_id yg bersangkutan dipakai oleh relasi
     * diprogram, untuk diperbolehkan hapus data tsb
     *
     * @param $bidang_id
     * @return mixed
     */
    public function findIsExists($bidang_id)
    {
        return $this->model
            ->where('bidang_id', '=', $bidang_id)
            ->get();
    }
}