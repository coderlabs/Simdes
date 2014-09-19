<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 19:06
 */

namespace Simdes\Repositories\Eloquent\Organisasi;

use Simdes\Models\Organisasi\Organisasi;
use Simdes\Models\User\User;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Services\Forms\Organisasi\OrganisasiEditForm;
use Simdes\Services\Forms\Organisasi\OrganisasiForm;

/**
 * Class OrganisasiRepository
 *
 * @package Simdes\Repositories\Eloquent\Organisasi
 */
class OrganisasiRepository extends AbstractRepository implements OrganisasiRepositoryInterface
{
    /**
     * @var
     */
    protected $user;

    /**
     * @param Organisasi $organisasi
     */
    public function __construct(Organisasi $organisasi, User $user)
    {
        $this->model = $organisasi;
        $this->user = $user;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        // pertama kali create user kemudian create organisasi
        // return berupa organisasi_id yang kemudian akan di
        // input dan diupdate pada  user yang bersangkutan
        $organisasi = $this->getNew();

        $nama = e($data['organisasi']);
        $organisasi->nama = $nama;
        $organisasi->email = e($data['email']);
        $random = str_random(3);
        $organisasi->slug = \Str::slug(strtolower($nama . $random), '-');
        $organisasi->save();

        return $organisasi->id;
    }


    /**
     * @param Organisasi $organisasi
     * @param array $data
     * @return array
     */
    public function update(Organisasi $organisasi, array $data)
    {
        // simpan dahulu ke tb_organisasi

        $organisasi->nama = e($data['nama']);
        $organisasi->alamat = e($data['alamat']);
        $organisasi->desa = e($data['desa']);
        $organisasi->kode_kec = e($data['kode_kec']);
        $organisasi->kode_kab = e($data['kode_kab']);
        $organisasi->kode_prov = e($data['kode_prov']);
        $organisasi->no_telp = e($data['no_telp']);
        $organisasi->email = e($data['email']);
        $organisasi->user_id = e($data['user_id']);
        $organisasi->save();

        // update user
        $user = $this->user->find($organisasi->user_id);
        $user->kab_id = $organisasi->kode_kab;
        $user->prov_id = $organisasi->kode_prov;
        $user->desa = $organisasi->desa;
        $user->save();

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.',
        ];
    }

    /**
     * @return OrganisasiForm
     */
    public function getCreationForm()
    {
        return new OrganisasiForm();
    }

    /**
     * @return OrganisasiEditForm
     */
    public function getEditForm()
    {
        return new OrganisasiEditForm();
    }

    /**
     * @param $organisasi_id
     * @return string
     */
    public function getKode($organisasi_id)
    {
        $data = $this->findById($organisasi_id);
        return $data->kode_kec . '.' . $data->kode_desa;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getNama($organisasi_id)
    {
        $data = $this->findById($organisasi_id);
        return $data->desa;
    }

    public function getListByKabId($term, $kab_id)
    {
        return $this->model
            ->where('kode_kab','=',$kab_id)
            ->FullTextSearch($term)
            ->where('organisasi_type','!=','backoffice')
            ->orderby('id','desc')
            ->remember(10)
            ->paginate(10,['id','desa','email','kab','is_active']);
    }

}