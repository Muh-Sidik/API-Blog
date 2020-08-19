<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegisterEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function verificationEmail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => "required",
                'errors'  => $validate->errors()
            ], 400);
        }

        $dataRequest = $request->all();
        $dataRequest['token'] = Str::random(32) . date('Ymd');
        $register = RegisterEmail::create($dataRequest);

        $this->sendEmail($request, $dataRequest['token']);

        if ($register) {
            return response()->json([
                'status' => "success",
                'message' => "Success Sending Email!",
            ]);
        }
    }
}
