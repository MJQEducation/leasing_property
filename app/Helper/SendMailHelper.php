<?php

namespace App\Helper;

use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendMailHelper
{
    public static function sendMailNotification($email, $data)
    {
        FacadesMail::to($email)->send(new MailNotify($data));

        return response()->json(['Success!']);
    }
}
