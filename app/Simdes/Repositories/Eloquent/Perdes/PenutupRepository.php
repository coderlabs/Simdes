<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:03
 */

namespace Simdes\Repositories\Eloquent\Perdes;


use Simdes\Models\Perdes\Penutup;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\PenutupRepositoryInterface;
use Simdes\Services\Forms\Perdes\PenutupEditForm;
use Simdes\Services\Forms\Perdes\PenutupForm;

/**
 * Class PenutupRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class PenutupRepository extends AbstractRepository implements PenutupRepositoryInterface
{
    /**
     * @param Penutup $penutup
     */
    public function __construct(Penutup $penutup)
    {
        $this->model = $penutup;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('pengundangan', 'LIKE', '%' . $term . '%')
            ->with('judul')
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
        $penutup = $this->getNew();

        $penutup->tempat = e($data['tempat']);
        $penutup->nomor = e($data['nomor']);
        $penutup->tahun = e($data['tahun']);
        $penutup->tanggal = e($data['tanggal']);
        $penutup->pengundangan = e($data['pengundangan']);
        $penutup->tanggal_pengundangan = e($data['tanggal_pengundangan']);
        $penutup->perdes_id = e($data['perdes_id']);
        $penutup->user_id = e($data['user_id']);
        $penutup->organisasi_id = e($data['organisasi_id']);
        $penutup->save();

        return $penutup;
    }

    /**
     * @param Penutup $penutup
     * @param array $data
     * @return Penutup
     */
    public function update(Penutup $penutup, array $data)
    {

        $penutup->tempat = e($data['tempat']);
        $penutup->nomor = e($data['nomor']);
        $penutup->tahun = e($data['tahun']);
        $penutup->tanggal = e($data['tanggal']);
        $penutup->pengundangan = e($data['pengundangan']);
        $penutup->tanggal_pengundangan = e($data['tanggal_pengundangan']);
        $penutup->perdes_id = e($data['perdes_id']);
        $penutup->user_id = e($data['user_id']);
        $penutup->save();

        return $penutup;
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
     * @return PenutupForm
     */
    public function getCreationForm()
    {
        return new PenutupForm();
    }

    /**
     * @return PenutupEditForm
     */
    public function getEditForm()
    {
        return new PenutupEditForm();
    }

} 