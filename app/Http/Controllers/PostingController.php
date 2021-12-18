<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\posting;
use Illuminate\Support\Facades\Storage;

class PostingController extends Controller
{
    function hapusdata($id)
    {
        $data = posting::where('id', $id)->first();
        $data->delete();

        return redirect('home');
    }

    function editdata(Request $request)
    {
        $data = posting::where('id', $request->id)->first();
        $data->caption = $request->caption ? $request->caption : $data->caption;
        $data->id = $request->id ? $request->id : $data->id;
        $data->id_user = $request->id_user ? $request->id_user : $data->id_user;
        $data->gambar = $request->gambar ? $request->gambar : $data->gambar;
        $data->save();

        return redirect('home');
    }

    function tambahdata(Request $request)
    {
        $data = new posting;

        if (empty($request->file('gambar'))) {
            $data->caption = $request->caption ;
            $data->id_user = $request->id_user ;
            $data->gambar = 'kosong';
            $data->save();
        }
        else{
            $data->caption = $request->caption ;
            $data->id_user = $request->id_user ;
            $img_name =  $request->file('gambar')->getClientOriginalName() . '-' . time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('foto/upload'), $img_name);
            $data->gambar = '/foto/upload/' . $img_name;
            $data->save();
        }
        return redirect('home');
    }
}
