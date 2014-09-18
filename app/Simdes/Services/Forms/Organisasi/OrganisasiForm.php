<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 18:59
 */

namespace Simdes\Services\Forms\Organisasi;


use Simdes\Services\Forms\AbstractForm;

/**
 * Class OrganisasiForm
 * @package Simdes\Services\Forms\Organisasi
 */
class OrganisasiForm extends AbstractForm
{

    // siapkan validasi untuk pertama kali daftar nama
    // dan email adalah nama dan email organisasi
    // user tipe ini adalah user administrator

    /**
     * @var array
     */
    protected $rules = [
        'nama'  => 'required|max:255',
        'email' => 'required|unique:organisasi,email'
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
            'email'
        ]);
    }

}