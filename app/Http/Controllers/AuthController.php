<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegisterEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

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

    public function SignUp(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|min:6',
            'no_hp' => 'required|number|min:11',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => "required",
                'errors'  => $validate->errors()
            ], 400);
        }

        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp'     => $request->no_hp,
                'no_detail_category' => $request->no_detail_category
            ]);

            return response()->json([
                'status' => "success",
                'message' => "User Successfully Created",
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "error",
                'message' => "Server Failed",
                'data' => "",
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'no_hp' => 'required|number|min:11',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => "required",
                'errors'  => $validate->errors()
            ], 400);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => "Unauthorized"], 401);
        }

        return $this->responseWithToken($token);
    }
}
