<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(HttpRequest $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()->first()], 400);
        }
        
        $user = User::where('email', '=', $request["email"])->first();
        if ($user != null && !$user->hasVerifiedEmail()) {

            return response(['message' => 'Not Verified'], 401);

        }

        if (!Auth::attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $karyawan = Auth::user();

        $token = $karyawan->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Selamat datang !',
            'user' => $karyawan,
            'token_type' => 'Bearer',
            'access_token' => $token
        ], 200);
    }

    public function register(HttpRequest $request)
    {
        $registerData = $request->all();
        $validate = Validator::make($registerData, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'nomor' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()->first()], 400);
        }

        $registerData["password"] = bcrypt($registerData["password"]);
        $user = User::create($registerData);

        try {
            $user->sendEmailVerificationNotification();
        } catch (Exception $e) {
            return response([
                'message' => 'Register Success, Email is not sent',
                'user' => $user,
            ], 200);
        }

        // $details = [
        //     'title' => 'Mail from ItSolutionStuff.com',
        //     'body' => 'Please click this link to verify your newly created account',
        //     'verification_link' => '',
        // ];

        // Mail::to($registerData["email"])->send(new \App\Mail\MyTestMail($details));

        return response([
            'message' => 'Berhasil terdaftar !',
            'user' => $user,
        ], 200);
    }
}
