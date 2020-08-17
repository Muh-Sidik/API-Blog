<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Cobaemail;

class EmailController extends Controller
{
    public function index()
    {
        $toName = "Sidik";
        $toEmail = "pasker.shinigami@gmail.com";

        $data = [
            'name' => "Muhammad Sidik",

        ];
    }
}
