<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 19:06
 */

namespace Simdes\Repositories\Eloquent\Organisasi;


use Simdes\Models\Organisasi\Organisasi;
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
     * @param Organisasi $organisasi
     */
    public function __construct(Organisasi $organisasi)
    {
        $this->model = $organisasi;
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


    public function update(Organisasi $organisasi, array $data)
    {

    }

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

    public function getKode($organisasi_id)
    {
        $data = $this->findById($organisasi_id);
        return $data->kode_kec . '.' . $data->kode_desa;
    }

    public function findById($organisasi_id)
    {
        return $this->model->find($organisasi_id);
    }

    public function getNama($organisasi_id)
    {
        $data = $this->findById($organisasi_id);
        return $data->desa;
    }

}