<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:14
 */

namespace Simdes\Repositories\Eloquent\Log;

use Carbon\Carbon;
use Simdes\Models\Log\Log;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Log\LogRepositoryInterface;

/**
 * Class AkunRepository
 *
 * @package Simdes\Repositories\Eloquent\Akun
 */
class LogRepository extends AbstractRepository implements LogRepositoryInterface
{

    /**
     * @param Log $log
     */
    public function __construct(Log $log)
    {
        $this->model = $log;
    }


    /**
     * @param $term
     * @param $organisasi_id
     * @param $user_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id, $user_id)
    {
        return $this->model
            ->where('deskripsi', 'LIKE', '%' . $term . '%')
            ->orWhere('organisasi_id', '=', $organisasi_id)
            ->orWhere('user_id', '=', $user_id)
            ->paginate(10);
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function storeLog($data)
    {
        $log = $this->getNew();

        $log->user_id = e($data[0]['user_id']);
        $log->organisasi_id = e($data[0]['organisasi_id']);
        $log->jenis = e($data[0]['jenis']);
        $log->deskripsi = e($data[0]['deskripsi']);
        $log->created_at = e($data[0]['created_at']);

        $log->save();
        return $log;
    }
}