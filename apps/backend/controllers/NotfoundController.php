<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Repositories\SendError;

class NotfoundController extends ControllerBase
{
    public function indexAction()
    {
        /**
         * Send Error Email
         */
        $message = "";
        if ($this->session->has('URL_NOTFOUND_SERVER')) {
            $URL_NOTFOUND_SERVER = $this->session->get('URL_NOTFOUND_SERVER');
            $this->session->remove('URL_NOTFOUND_SERVER');
            $sent_error = new SendError();
            $sent_error->sendErrorNotfound($message, $URL_NOTFOUND_SERVER);
        }
    }

    public function notfoundAction()
    {
        $this->my->sendErrorEmailAndRedirectToNotFoundPage();
    }
}