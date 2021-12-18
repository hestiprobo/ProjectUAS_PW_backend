<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\komentar;
use App\Models\posting;
use App\Models\User;

class ProfilController extends Controller
{
    function viewprofil($id)
    {
        $user = User::where('id', $id)->first();
        $data  =  posting::where('id_user', $id)->get();
        $user_komentar = komentar::all();
        $nilai = 0;

        return view('profiluser', ['posting' => $data, 'User' => $user, 'komentar' => $user_komentar, 'nilai' => $nilai]);
    }
    function editprofil(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->name = $request->name ? $request->name : $user->name;
        $user->email = $request->email ? $request->email : $user->email;
        $user->nomor = $request->nomor ? $request->nomor : $user->nomor;
        $user->save();

        return redirect('/user/profil/' . $request->id);
    }
    function uploadfoto(Request $request)
    {
        if (!empty($request->file('foto'))) {
            $user = User::where('id', $request->id)->first();
            $img_name =  $request->file('foto')->getClientOriginalName() . '-' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto/profil'), $img_name);
            $user->foto = '/foto/profil/' . $img_name;
            $user->save();
        }
        else{

        }

        return redirect('/user/profil/' . $request->id);
    }
}
