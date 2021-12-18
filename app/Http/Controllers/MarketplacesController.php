<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\marketplace;
use App\Models\User;
use App\Models\marketkomentar;

class MarketplacesController extends Controller
{
    function view()
    {
        $data = marketplace::all();
        $user_data = User::all();
        $user_komentar = marketkomentar::all();
        $nilai = 0;

        return view('usermarketplaces', ['posting' => $data, 'User' => $user_data, 'komentar' => $user_komentar, 'nilai' => $nilai]);
    }
    function tambah(Request $request)
    {
        $data = new marketplace;

        if (empty($request->file('foto'))) {
            $data->deskripsi = $request->deskripsi;
            $data->harga = $request->harga;
            $data->title = $request->title;
            $data->id_user = $request->id_user;
            $data->keterangan = 'available';
            $data->foto = 'kosong';
            $data->save();
        } else {
            $data->deskripsi = $request->deskripsi;
            $data->harga = $request->harga;
            $data->title = $request->title;
            $data->id_user = $request->id_user;
            $data->keterangan = 'available';
            $img_name =  $request->file('foto')->getClientOriginalName() . '-' . time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto/marketplaces'), $img_name);
            $data->foto = '/foto/marketplaces/' . $img_name;
            $data->save();
        }
        return redirect('user/marketplaces');
    }
    function hapus($id){
        $data = marketplace::where('id', $id)->first();
        $data->delete();

        return redirect('user/marketplaces');
    }
    function edit(Request $request){
        $data = marketplace::where('id', $request->id)->first();
        $data->deskripsi = $request->deskripsi ? $request->deskripsi : $data->deskripsi;
        $data->id = $request->id ? $request->id : $data->id;
        $data->id_user = $request->id_user ? $request->id_user : $data->id_user;
        $data->harga = $request->harga ? $request->harga : $data->harga;
        $data->title = $request->title ? $request->title : $data->title;
        $data->foto = $request->foto ? $request->foto : $data->foto;
        $data->save();

        return redirect('user/marketplaces');
    }
    function viewkomentar($id){
        $data_user = User::all();
        $data = marketplace::where('id',$id)->get();
        $data_komentar = marketkomentar::where('id_market',$id)->get();

        return view('usermarketplaceskomentar',['data'=> $data,'user'=>$data_user,'id_market'=>$id,'komentar'=>$data_komentar]);
    }
    function tambahkomentar(Request $request){
        $data = new marketkomentar;
        $data->id_market = $request->id_market;
        $data->id_user = $request->id_user;
        $data->komentar = $request->komentar;
        $data->save();

        return redirect('user/marketplaces/komentar/'.$request->id_market);
    }
    function editkomentar(Request $request){
        $data = marketkomentar::where('id',$request->id)->first();
        $data->komentar = $request->komentar;
        $data->save();

        return redirect('user/marketplaces/komentar/'.$request->id_market);
    }
    function hapuskomentar($id){
        $data = marketkomentar::where('id',$id)->first();
        $pages = $data->id_market;
        $data->delete();

        return redirect('user/marketplaces/komentar/'.$pages);
    }
}
