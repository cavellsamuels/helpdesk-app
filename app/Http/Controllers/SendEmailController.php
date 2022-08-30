<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index()
    {
        Mail::to('cavellksamuels@gmail.com')->send(new WelcomeMail());

        return new WelcomeMail();
    }
}
