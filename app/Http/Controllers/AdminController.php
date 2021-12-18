<?php

namespace App\Http\Controllers;

use App\Models\komentar;
use Illuminate\Http\Request;
use App\Models\posting;
use App\Models\User;
use App\Models\marketkomentar;
use App\Models\marketplace;

class AdminController extends Controller
{
    function view()
    {
        $data  =  posting::all();
        $user_data = User::all();
        $user_komentar = komentar::all();
        $nilai = 0;
        return view('adminberanda', ['posting' => $data, 'User' => $user_data, 'komentar' => $user_komentar, 'nilai' => $nilai]);
    }
    function viewmanajemen()
    {
        $data = User::all();
        return view('adminmanajemenuser', ['user' => $data]);
    }
    function hapususer($id)
    {
        $data = User::where('id', $id)->first();
        $data->delete();

        return redirect('/admin/manajemenuser');
    }
    function viewmarketplaces()
    {
        $data = marketplace::all();
        $user_data = User::all();
        $user_komentar = marketkomentar::all();
        $nilai = 0;

        return view('adminmarketplaces', ['posting' => $data, 'User' => $user_data, 'komentar' => $user_komentar, 'nilai' => $nilai]);
    }
    function hapusmarketplaces($id){
        $data = marketplace::where('id', $id)->first();
        $data->delete();

        return redirect('admin/marketplaces');
    }
    function editmarketplaces(Request $request){
        $data = marketplace::where('id', $request->id)->first();
        $data->deskripsi = $request->deskripsi ? $request->deskripsi : $data->deskripsi;
        $data->id = $request->id ? $request->id : $data->id;
        $data->id_user = $request->id_user ? $request->id_user : $data->id_user;
        $data->harga = $request->harga ? $request->harga : $data->harga;
        $data->title = $request->title ? $request->title : $data->title;
        $data->foto = $request->foto ? $request->foto : $data->foto;
        $data->save();

        return redirect('admin/marketplaces');
    }
    function tambahmarketplaces(Request $request)
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
        return redirect('admin/marketplaces');
    }
    function komentarmarketplaces($id)
    {
        $data_user = User::all();
        $data = marketplace::where('id',$id)->get();
        $data_komentar = marketkomentar::where('id_market',$id)->get();

        return view('adminmarketplaceskomentar',['data'=> $data,'user'=>$data_user,'id_market'=>$id,'komentar'=>$data_komentar]);
    }
    function tambahkomentarmarketplaces(Request $request)
    {
        $data = new marketkomentar;
        $data->id_market = $request->id_market;
        $data->id_user = $request->id_user;
        $data->komentar = $request->komentar;
        $data->save();

        return redirect('admin/marketplaces/komentar/'.$request->id_market);
    }
    function hapuskomentarmarketplaces($id)
    {
        $data = marketkomentar::where('id',$id)->first();
        $pages = $data->id_market;
        $data->delete();

        return redirect('admin/marketplaces/komentar/'.$pages);
    }
    function editkomentarmarketplaces(Request $request){
        $data = marketkomentar::where('id',$request->id)->first();
        $data->komentar = $request->komentar;
        $data->save();

        return redirect('admin/marketplaces/komentar/'.$request->id_market);
    }
    function hapusdata($id)
    {
        $data = posting::where('id', $id)->first();
        $data->delete();

        return redirect('/admin/beranda');
    }
    function editdata(Request $request)
    {
        $data = posting::where('id', $request->id)->first();
        $data->caption = $request->caption ? $request->caption : $data->caption;
        $data->id = $request->id ? $request->id : $data->id;
        $data->id_user = $request->id_user ? $request->id_user : $data->id_user;
        $data->gambar = $request->gambar ? $request->gambar : $data->gambar;
        $data->save();

        return redirect('/admin/beranda');
    }
    function viewkomentar($id)
    {
        $data_komentar  = komentar::where('id_post', $id)->get();
        $data_posting   = posting::where('id', $id)->get();
        $data_user   = User::all();


        return view('adminkomentar', ['komentar' => $data_komentar, 'posting' => $data_posting,'user'=>$data_user,'id_posting'=>$id]);
    }
    function kirimkomentar(Request $request){
        $data = new komentar;
        $data->id_user = $request->id_user;
        $data->komentar = $request->komentar;
        $data->id_post = $request->id_post;
        $data->save();

        return redirect('/admin/komentar/'.$request->id_post);
    }
    function hapuskomentar($id,$id_post){
        $data = komentar::where('id',$id)->first();
        $data->delete();

        return redirect('/admin/komentar/'.$id_post);
    }
    function editkomentar(Request $request){
        $data =  komentar::where('id',$request->id)->first();
        $data->komentar = $request->komentar;
        $data->save();
        return redirect('/admin/komentar/'.$request->id_post);
    }

}
