<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/02/2018
 * Time: 04:57 PM.
 */

namespace Greenter\Notify;

/**
 * Interface NotificatorInterface.
 */
interface NotificatorInterface
{
    /**
     * @param Notification $notification
     * @param array        $options
     *
     * @return mixed
     */
    public function notify(Notification $notification, $options = []);
}
