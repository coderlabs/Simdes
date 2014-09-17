<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/31/2014
 * Time: 18:16
 */

namespace Simdes\Repositories\Eloquent\Pejabat;

use Simdes\Models\Pejabat\PejabatDesa;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;
use Simdes\Services\Forms\Pejabat\PejabatDesaEditForm;
use Simdes\Services\Forms\Pejabat\PejabatDesaForm;
use User\UserRegistrationController;

/**
 * Class PejabatDesaRepository
 * @package Simdes\Repositories\Eloquent\Pejabat
 */
class PejabatDesaRepository extends AbstractRepository implements PejabatDesaRepositoryInterface
{
    /**
     * @var \Simdes\Repositories\User\UserRepositoryInterface
     */
    protected $user;

    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;

    /**
     * @param PejabatDesa $pejabatDesa
     */
    public function __construct(PejabatDesa $pejabatDesa, UserRepositoryInterface $user, OrganisasiRepositoryInterface $organisasi)
    {
        $this->model = $pejabatDesa;
        $this->user = $user;
        $this->organisasi = $organisasi;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->where('nama', 'LIKE', '%' . $term . '%')
            ->where('organisasi_id', '=', $organisasi_id)
            ->paginate(10);
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $pejabat = $this->getNew();

        $nama = e($data['nama']);
        $organisasi_id = e($data['organisasi_id']);
        $tanggal = e($data['tanggal_sk']);

        $pejabat->nama = $nama;
        $pejabat->jabatan = e($data['jabatan']);
        $pejabat->nip = e($data['nip']);
        $pejabat->fungsi = e($data['fungsi']);
        $pejabat->nomer_sk = e($data['nomer_sk']);
        $pejabat->judul = e($data['judul']);
        $pejabat->pejabat = e($data['pejabat']);
        $pejabat->tanggal_sk = date("Y-m-d", strtotime($tanggal));
        $pejabat->organisasi_id = $organisasi_id;

        $pejabat->save();

        return $pejabat;
    }

    /**
     * @param PejabatDesa $pejabat
     * @param array $data
     * @return PejabatDesa
     */
    public function update(PejabatDesa $pejabat, array $data)
    {
        $nama = e($data['nama']);
        $date = e($data['tanggal_sk']);
        $organisasi_id = e($data['organisasi_id']);
        $date = date('Y-m-d', strtotime($date));
        $pejabat->nama = $nama;
        $pejabat->jabatan = e($data['jabatan']);
        $pejabat->nip = e($data['nip']);
        $pejabat->fungsi = e($data['fungsi']);
        $pejabat->nomer_sk = e($data['nomer_sk']);
        $pejabat->judul = e($data['judul']);
        $pejabat->pejabat = e($data['pejabat']);
        $pejabat->tanggal_sk = $date;
        $pejabat->save();

        return $pejabat;
    }

    /**
     * @param $organisasi_id
     * @param $fungsi
     * @return mixed
     */
    public function getPejabat($organisasi_id, $fungsi)
    {
        $data = $this->model->where('organisasi_id', '=', $organisasi_id)->where('jabatan', '=', 'Kepala Desa')->first();

        return $data->nama;
    }

    /**
     * @param $id
     * @param $organisasi_id
     * @return mixed
     */
    public function findById($id, $organisasi_id)
    {
        return $this->model->where('id', '=', $id)->where('organisasi_id', '=', $organisasi_id)->first();
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $data = $this->model->find($id);
        $data->delete();
    }

    /**
     * @return PejabatDesaForm
     */
    public function getCreationForm()
    {
        return new PejabatDesaForm();
    }

    /**
     * @return PejabatDesaEditForm
     */
    public function getEditForm()
    {
        return new PejabatDesaEditForm();
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get(['id', 'nama', 'jabatan']);
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getKades($organisasi_id)
    {
        $data = $this->model->where('organisasi_id', '=', $organisasi_id)->where('jabatan', '=', 'Kepala Desa')->first();
        if(is_null($data)){
            return '[Belum diset]';
        }
        return $data->nama;
    }

    public function getBendahara($organisasi_id)
    {
        $data = $this->model->where('organisasi_id', '=', $organisasi_id)->where('fungsi', '=', 'Bendahara Desa')->first();
        if(is_null($data)){
            return '[Belum diset]';
        }
        return $data->nama;
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getSekdes($organisasi_id)
    {
        $data = $this->model->where('organisasi_id', '=', $organisasi_id)->where('jabatan', '=', 'Sekretaris Desa')->first();
        if(is_null($data)){
            return '[Belum diset]';
        }
        return $data->nama;
    }

    public function getCamat($organisasi_id)
    {
        $data = $this->model->where('organisasi_id', '=', $organisasi_id)->where('jabatan', '=', 'Camat')->first();
        return [
            'nama' => $data->nama,
            'nip'  => $data->nip
        ];
    }

    public function getBupati($organisasi_id)
    {
        $data = $this->model->where('organisasi_id', '=', $organisasi_id)->whereIn('jabatan', ['Bupati', 'Walikota'])->first();
        return [
            'nama'   => $data->nama,
            'jabatan' => $data->jabatan
        ];
    }
}