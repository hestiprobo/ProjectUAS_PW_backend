<?php

namespace App\Http\Controllers;

use App\Models\komentar;
use Illuminate\Http\Request;
use App\Models\posting;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data  =  posting::all();
        $user_data = User::all();
        $user_komentar = komentar::all();
        $nilai = 0;
        return view('home',['posting'=> $data,'User'=>$user_data,'komentar'=> $user_komentar,'nilai'=>$nilai]);
    }
}
