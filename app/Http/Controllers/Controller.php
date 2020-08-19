<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function sendEmail(Request $request, $token)
    {
        $data = [
            'token' => $token,
        ];

        // dd($request);

        $send = Mail::send('email', $data, function ($message) use ($request) {
            $message->from('meme.chan100@gmail.com', 'Official')
                ->to($request->email)
                ->subject('Verification Email!');
        });

        return true;
    }
}
