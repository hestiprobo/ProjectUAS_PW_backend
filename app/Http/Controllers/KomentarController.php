<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\komentar;
use Illuminate\Support\Facades\App;
use App\Models\posting;
use App\Models\User;

class KomentarController extends Controller
{
    function viewkomentar($id)
    {
        $data_komentar  = komentar::where('id_post', $id)->get();
        $data_posting   = posting::where('id', $id)->get();
        $data_user   = User::all();


        return view('userkomentar', ['komentar' => $data_komentar, 'posting' => $data_posting, 'user' => $data_user, 'id_posting' => $id]);
    }

    function kirimkomentar(Request $request)
    {
        $data = new komentar;
        $data->id_user = $request->id_user;
        $data->komentar = $request->komentar;
        $data->id_post = $request->id_post;
        $data->save();

        return redirect('/user/komentar/' . $request->id_post);
    }
    function hapuskomentar($id, $id_post)
    {
        $data = komentar::where('id', $id)->first();
        $data->delete();

        return redirect('/user/komentar/' . $id_post);
    }
    function editkomentar(Request $request)
    {
        $data =  komentar::where('id', $request->id)->first();
        $data->komentar = $request->komentar;
        $data->save();
        return redirect('/user/komentar/' . $request->id_post);
    }
}
