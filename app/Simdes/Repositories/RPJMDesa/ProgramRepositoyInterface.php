<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:56
 */

namespace Simdes\Repositories\RPJMDesa;


use Simdes\Models\RPJMDesa\Program;

/**
 * Interface ProgramRepositoyInterface
 *
 * @package Simdes\Repositories\RPJMDesa
 */
interface ProgramRepositoyInterface
{

    /**
     * @param $term
     * @param $masalah_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $masalah_id, $organisasi_id);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);


    /**
     * @param Program $program
     * @param array $data
     *
     * @return mixed
     */
    public function update(Program $program, array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @return mixed
     */
    public function getCreationForm();

    /**
     * @return mixed
     */
    public function getEditForm();


    /**
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findProgramList($organisasi_id);

    /**
     * @param $program_id
     *
     * @return mixed
     */
    public function getProgram($program_id);
    
    /**
     * Menampilkan data prgoram yang telah diRPJMDesa kan
     * akan ditampilkan di RKPDesa outpurnya ada tiga
     * rpjmdesa_id|id|program
     *
     * @param $organisasi_id
     * @return mixed
     */

    public function getListProgram($organisasi_id);

    /**
     * @param $sumber_dana_id
     *
     * @return mixed
     */
    public function getStringSumberDana($sumber_dana_id);

    /**
     * @param $organisasi_id
     * @param $progam_id
     *
     * @return mixed
     */
    public function isProgramUsedByUserId($organisasi_id, $progam_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findforCetak($organisasi_id);

    /**
     * Get data program untuk cetak formulir RPJMDesa
     * berdasarkan jenis dari sumber dana : swadaya
     * masyarakat dan bantuan dari pihak ketiga
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir1($organisasi_id);

    /**
     * Get data program untuk cetak formulir RPJMDesa
     * berdasarkan : sumber dana yang ada dananya
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir2($organisasi_id);

    /**
     * Get data program untuk cetak formulir RPJMDesa
     * berdasarkan sumber dana swadaya dan dana
     * yang sudah ada tugas bantuan
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir3($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir4($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir5($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir6($organisasi_id);

}