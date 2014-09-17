<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:05
 */

namespace Simdes\Repositories\Log;

/**
 * Interface AkunRepositoryInterface
 *
 * @package Simdes\Repositories\Akun
 */
interface LogRepositoryInterface
{

    /**
     * Menampilkan semua log/aktifitas user
     * filter pencarian berdasarkan param
     *
     * @param $term => keyword pencarian
     * @param $organisasi_id => keyword organisasi_id
     * @param $user_id => keyword tiap user
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id, $user_id);

    public function storeLog($data);
}