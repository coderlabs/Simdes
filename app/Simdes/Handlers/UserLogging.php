<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 7/23/2014
 * Time: 13:10
 */

namespace Simdes\Handlers;

use Simdes\Repositories\Log\LogRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;


/**
 * Class UserMailer
 * @package Simdes\Mailers
 */
class UserLogging
{

    private $log;

    public function __construct(
        LogRepositoryInterface $log
    )
    {
        $this->log = $log;
    }

    public function userLogin($data)
    {
        $this->log->storeLog([$data]);
    }

    public function userLog()
    {

    }


}