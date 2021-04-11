<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class MailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'title' => 'Mail from QR BUILDER',
            'body' => 'This is testing Email'
        ];
        Mail::to("liktejas@gmail.com")->send(new UserMail($details));
        return 'Mail Send';
    }
}
