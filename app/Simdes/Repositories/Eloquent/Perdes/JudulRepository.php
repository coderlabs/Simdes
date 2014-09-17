<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 20:26
 */

namespace Simdes\Repositories\Eloquent\Perdes;


use Simdes\Models\Perdes\Judul;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Services\Forms\Perdes\JudulEditForm;
use Simdes\Services\Forms\Perdes\JudulForm;

/**
 * Class JudulRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class JudulRepository extends AbstractRepository implements JudulRepositoryInterface
{

    /**
     * @param Judul $judul
     */
    public function __construct(Judul $judul)
    {
        $this->model = $judul;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('judul', 'LIKE', '%' . $term . '%')
            ->paginate(10);
    }

    /**
     * @param $perdes_id
     * @param $organisasi_id
     * @return mixed
     */
    public function findByPerdesId($perdes_id, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('perdes_id', '=', $perdes_id)
            ->first();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $judul = $this->getNew();

        $judul->tempat = e($data['tempat']);
        $judul->tahun = e($data['tahun']);
        $judul->tanggal = e($data['tanggal']);
        $judul->pengundangan = e($data['pengundangan']);
        $judul->tanggal_pengundangan = e($data['tanggal_pengundangan']);
        $judul->judul = e($data['judul']);
        $judul->jenis = e($data['jenis']);
        $judul->nomor = e($data['nomor']);
        $judul->user_id = e($data['user_id']);
        $judul->organisasi_id = e($data['organisasi_id']);
        $judul->save();

        return $judul;
    }

    /**
     * @param Judul $judul
     * @param array $data
     * @return Judul
     */
    public function update(Judul $judul, array $data)
    {

        $judul->tempat = e($data['tempat']);
        $judul->tahun = e($data['tahun']);
        $judul->tanggal = e($data['tanggal']);
        $judul->pengundangan = e($data['pengundangan']);
        $judul->tanggal_pengundangan = e($data['tanggal_pengundangan']);
        $judul->judul = e($data['judul']);
        $judul->jenis = e($data['jenis']);
        $judul->nomor = e($data['nomor']);
        $judul->user_id = e($data['user_id']);
        $judul->save();

        return $judul;
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return void
     */
    public function delete($id, $organisasi_id)
    {
        $data = $this->findById($id, $organisasi_id);
        $data->delete();
    }

    /**
     * @param $id
     * @param $organisasi_id
     * @return mixed
     */
    public function findById($id, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * @return JudulForm
     */
    public function getCreationForm()
    {
        return new JudulForm();
    }

    /**
     * @return JudulEditForm
     */
    public function getEditForm()
    {
        return new JudulEditForm();
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get(['id', 'judul']);
    }
}