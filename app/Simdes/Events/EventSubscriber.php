<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 7/23/2014
 * Time: 13:45
 */

namespace Simdes\Events;


/**
 * Class EventSubscriber
 * @package Simdes\Events
 */
class EventSubscriber
{

    /**
     * Mendaftarkan semua event listen yang ditangkap
     * dari event fire
     *
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('user.signup', 'Simdes\Mailers\UserMailer@welcome');
        $events->listen('user.create', 'Simdes\Mailers\UserMailer@createUser');
        $events->listen('reset.password', 'Simdes\Mailers\UserMailer@resetPassword');
        $events->listen('user.login', 'Simdes\Handlers\UserLogging@userLogin');
    }

} 