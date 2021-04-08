<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Http\Requests\Auth\GuestStoreRequest;
use App\Http\Requests\Auth\GuestLoginRequest;
use App\Mail\GuestRegister;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class GuestLoginController extends Controller
{
    private $secret;
    public function __construct()
    {
        $this->secret = config('pp.secret');
    }
    public function register(GuestStoreRequest $request)
    {
        $data = Guest::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        $mailData = [
            'url' => URL::temporarySignedRoute('guest.activate', now()->addDays(1), ['id' => $data->id]),
            'msg' => 'Activate your account by clicking the button below.',
            'data' => $data,
        ];
        Mail::to(request('email'))->queue(new GuestRegister($mailData));

        return response()->json([
            'message' => 'User successfully registered!',
        ], 201);
    }

    public function login(GuestLoginRequest $request)
    {
        $creds = Guest::firstWhere('email', request('email'));
        if (!empty($creds) && Hash::check(request('password'), $creds->password)) {
            $token = $creds->createToken($this->secret, ['guest'])->accessToken;
            return response()->json(['data' => $creds, 'access_token' => $token ],201);
        } 
            return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function activateGuest($id)
    {
        if (!request()->hasValidSignature()) {
            abort(401);
        }

        $guest = Guest::where('id', $id)->first();

        if (!empty($guest->email_verified_at)) {
            return response()->json(['msg' => 'email already verified'], 500);
        } else {
            $guest->email_verified_at = date('Y-m-d h:i:s');
            $guest->save();
        }
        return response()->json(['msg' => 'Email Activated Please Close This Tab'], 201);
    }
}
