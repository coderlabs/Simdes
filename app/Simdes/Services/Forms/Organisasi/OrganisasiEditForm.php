<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 18:59
 */

namespace Simdes\Services\Forms\Organisasi;


use Simdes\Services\Forms\AbstractForm;

class OrganisasiEditForm extends AbstractForm
{

    protected $rules = [
        'nama'      => 'required',
        'alamat'    => 'required',
        'desa'      => 'required',
        'kode_kec'  => 'required|integer',
        'kode_kab'  => 'required|integer',
        'kode_prov' => 'required|integer',
        'no_telp'   => 'required',
        'email'     => 'required|email'
    ];

    /**
     * Menpersiapkan data untuk jadi input
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'nama',
            'alamat',
            'desa',
            'kode_kec',
            'kec',
            'kode_kab',
            'kab',
            'kode_prov',
            'prov',
            'no_telp',
            'fax',
            'email',
            'website',
            'kode_desa',
            'logo',
            'slug'
        ]);
    }

}