<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\posting;
use App\Models\komentar;
use App\Models\marketplace;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\marketkomentar;
use Marketplace as GlobalMarketplace;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class ApiController extends Controller
{
    function tampilkanpostingan()
    {
        $data  =  posting::with(['getKomentar', 'getUser'])->get();

        return response()->json([
            'pesan' => 'Pengambilan Data berhasil',
            'data' => $data,
        ]);
    }
    function tampilkanpostinganbyid($id)
    {
        $data  =  posting::with(['getKomentar.getCommentedUser', 'getUser'])->where('id', $id)->first();

        if (empty($data)) {
            return response()->json([
                'pesan' => 'Pengambilan Data Gagal. Tidak ditemukan data dengan id ' . $id,
            ]);
        } else {
            return response()->json([
                'pesan' => 'Pengambilan Data berhasil',
                'data' => $data,
            ]);
        }
    }
    function tambahpostingan(Request $request)
    {

        if (empty($request->id_user)) {
            return response()->json([
                'pesan' => 'masukkan id_user',
            ]);
        } elseif (empty($request->caption)) {
            return response()->json([
                'pesan' => 'masukkan caption',
            ]);
        } else {

            $data = new posting;
            if (empty($request->file('gambar'))) {
                $data->caption = $request->caption;
                $data->id_user = $request->id_user;
                $data->gambar = 'kosong';
                $data->save();
            } else {
                $data->caption = $request->caption;
                $data->id_user = $request->id_user;
                $img_name =  $request->file('gambar')->getClientOriginalName() . '-' . time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('foto/upload'), $img_name);
                $data->gambar = '/foto/upload/' . $img_name;
                $data->save();
                return response()->json([
                    'pesan' => 'data berhasil ditambahkan',
                    'data' => $data,
                ]);
            }
        }
    }
    function editpostingan(Request $request, $id)
    {
        $requestData = $request->all();
        $updateData = $request->all();

        $validasi_post = posting::where('id', $id)->first();
        if (empty($validasi_post->id)) {
            return response()->json([
                'pesan' => 'GAGAL. Postingan tidak ditemukan dalam database',
            ]);
        } else {
            // error_log(gettype($requestData["gambar"]));
            $data = posting::where('id', $id)->first();
            $data->caption = $request->caption != null ? $request->caption : $data->caption;
            // $data->id = $request->id != null ? $request->id : $data->id;
            $data->id_user = $request->id_user != null ? $request->id_user : $data->id_user;

            if ($requestData["gambar"] != $data->gambar) {
                // $img_name =  $request->file('gambar')->getClientOriginalName() . '-' . time() . '.' . $request->gambar->extension();
                // $request->gambar->move(public_path('foto/upload'), $img_name);
                // $data->gambar = '/foto/upload/' . $img_name;

                $image = $updateData["gambar"];  // your base64 encoded
                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $replace = substr($image, 0, strpos($image, ',') + 1);
                $image = str_replace($replace, '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10) . '.' . $extension;
                // Storage::put(public_path() . '/foto/upload/' . $imageName, base64_decode($image));
                Storage::disk('public')->put($imageName, base64_decode($image));
                $data->gambar = '/' . $imageName;
                error_log($data->gambar);

                // $data->gambar = $request->gambar ? $request->gambar : $data->gambar;
            }

            if ($data->save()) {
                return response()->json([
                    'pesan' => 'data berhasil diubah',
                    'data' => $requestData,
                ]);
            }
        }
    }
    function hapuspostingan($id)
    {
        $data = posting::where('id', $id)->first();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            $data->delete();
            return response()->json([
                'pesan' => 'data berhasil dihapus',
            ]);
        }
    }










    function viewkomentar()
    {
        $data_komentar  = komentar::with(['getPost', 'getCommentedUser'])->all();

        return response()->json([
            'pesan' => 'data berhasil diambil',
            'data'  => $data_komentar,
        ]);
    }

    function kirimkomentar(Request $request)
    {

        if (empty($request->id_user)) {
            return response()->json([
                'pesan' => 'silahkan masukkan id_user'
            ]);
        } elseif (empty($request->id_post)) {
            return response()->json([
                'pesan' => 'silahkan masukkan id_post'
            ]);
        } else {
            $validasi_user = User::where('id', $request->id_user)->first();
            $validasi_post = posting::where('id', $request->id_post)->first();

            if (empty($validasi_post)) {
                return response()->json([
                    'pesan' => 'postingan dengan id ' . $request->id_post . ' tidak ditemukan'
                ]);
            } elseif (empty($validasi_user)) {
                return response()->json([
                    'pesan' => 'user dengan id ' . $request->id_user . ' tidak ditemukan'
                ]);
            } else {
                $data = new komentar;
                $data->id_user = $request->id_user;
                $data->id_post = $request->id_post;
                $data->komentar = $request->komentar;
                $data->save();

                return response()->json([
                    'pesan' => 'data berhasil tambah',
                    'data'  => $data,
                ]);
            }
        }
    }
    function editkomentar($id, Request $request)
    {
        $data =  komentar::where('id', $request->id)->first();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'komentar dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            $data->komentar = $request->komentar;
            $data->save();

            return response()->json([
                'pesan' => 'data berhasil edit',
                'data'  => $data,
            ]);
        }
    }
    function hapuskomentar($id)
    {
        $data = komentar::where('id', $id)->first();
        if (empty($data->id)) {

            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            $data->delete();
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' telah dihapus',
            ]);
        }
    }
    function viewkomentarbyid($id)
    {
        $data = komentar::with(['getPost.getUser', 'getCommentedUser'])->where('id', $id)->first();
        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            return response()->json([
                'pesan' => 'data berhasil ditemukan',
                'data'  => $data,
            ]);
        }
    }









    function viewmarketplaces()
    {
        $data = marketplace::with(['getUser', 'getKomentar.getCommentedUser'])->get();

        return response()->json([
            'pesan' => 'data berhasil ditemukan',
            'data'  => $data,
        ]);
    }
    function viewmarketplacesbyid($id)
    {
        $data = marketplace::with(['getUser', 'getKomentar.getCommentedUser'])->where('id', $id)->first();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {

            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' ditemukan',
                'data'  => $data,
            ]);
        }
    }
    function tambahmarketplaces(Request $request)
    {
        $data = new marketplace;

        if (empty($request->deskripsi)) {
            return response()->json([
                'pesan' => 'masukkan deskripsi',
            ]);
        } elseif (empty($request->harga)) {
            return response()->json([
                'pesan' => 'masukkan harga',
            ]);
        } elseif (empty($request->title)) {
            return response()->json([
                'pesan' => 'masukkan title',
            ]);
        } elseif (empty($request->id_user)) {
            return response()->json([
                'pesan' => 'masukkan id_user',
            ]);
        } else {
            $validasi_user = User::where('id', $request->id_user)->first();

            if (empty($validasi_user->id)) {
                return response()->json([
                    'pesan' => 'id_user ' . $request->id_user . ' tidak ditemukan',
                ]);
            } else {
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
                return response()->json([
                    'pesan' => 'data telah disimpan',
                    'data'  => $data,
                ]);
            }
        }
    }
    function editmarketplaces($id, Request $request)
    {
        $data = marketplace::where('id', $id)->first();
        $requestData = $request->all();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'id_post ' . $request->id_post . ' tidak ditemukan',
            ]);
        } else {
            $data->id = $request->id != null ? $request->id : $data->id;
            $data->harga = $request->harga != null ? $request->harga : $data->harga;
            $data->title = $request->title != null ? $request->title : $data->title;
            $data->id_user = $request->id_user != null ? $request->id_user : $data->id_user;
            $data->deskripsi = $request->deskripsi != null ? $request->deskripsi : $data->deskripsi;
            // $data->foto = $request->foto ? $request->foto : $data->foto;

            if ($requestData["foto"] != $data->foto) {
                // $img_name =  $request->file('gambar')->getClientOriginalName() . '-' . time() . '.' . $request->gambar->extension();
                // $request->gambar->move(public_path('foto/upload'), $img_name);
                // $data->gambar = '/foto/upload/' . $img_name;

                $image = $requestData["foto"];  // your base64 encoded
                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $replace = substr($image, 0, strpos($image, ',') + 1);
                $image = str_replace($replace, '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10) . '.' . $extension;
                // Storage::put(public_path() . '/foto/upload/' . $imageName, base64_decode($image));
                Storage::disk('public')->put($imageName, base64_decode($image));
                $data->foto = '/' . $imageName;
                error_log($data->foto);

                // $data->gambar = $request->gambar ? $request->gambar : $data->gambar;
            }

            if ($data->save()) {
                return response()->json([
                    'pesan' => 'data berhasil diubah',
                    'data' => $requestData,
                ]);
            }
        }
    }
    function hapusmarketplaces($id)
    {
        $data = marketplace::where('id', $id)->first();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            $data->delete();
            return response()->json([
                'pesan' => 'data telah dihapus',
            ]);
        }
    }








    function viewkomentarmarketplaces()
    {
        $data = marketkomentar::with(['getMarket', 'getCommentedUser'])->get();

        return response()->json([
            'pesan' => 'data berhasil diambil',
            'data'  => $data,
        ]);
    }
    function viewkomentarmarketplacesbyid($id)
    {
        $data = marketkomentar::with(['getMarket', 'getCommentedUser'])->where('id', $id)->first();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {

            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' berhasil diambil',
                'data'  => $data,
            ]);
        }
    }
    function tambahkomentarmarketplaces(Request $request)
    {
        $validasi_post = marketplace::where('id', $request->id_market)->first();
        $validasi_user = User::where('id', $request->id_user)->first();
        if (empty($validasi_post->id)) {
            return response()->json([
                'pesan' => 'data market dengan id ' . $request->id_market . ' tidak ditemukan',
            ]);
        } elseif (empty($validasi_user->id)) {
            return response()->json([
                'pesan' => 'data user dengan id ' . $request->id_user . ' tidak ditemukan',
            ]);
        } else {

            $data = new marketkomentar;
            $data->id_user = $request->id_user;
            $data->komentar = $request->komentar;
            $data->id_market = $request->id_market;
            $data->save();
            return response()->json([
                'pesan' => 'data berhasil ditambahkan',
                'data'  => $data,
            ]);
        }
    }
    function editkomentarmarketplaces($id, Request $request)
    {
        if (empty($request->id_market)) {
            return response()->json([
                'pesan' => 'id_market tidak boleh kosong',
            ]);
        } elseif (empty($request->id_user)) {
            return response()->json([
                'pesan' => 'id_user tidak boleh kosong',
            ]);
        } else {

            $validasi_market = marketplace::where('id', $request->id_market)->first();
            $validasi_user = User::where('id', $request->id_user)->first();

            if (empty($validasi_market)) {
                return response()->json([
                    'pesan' => 'data marketplaces dengan id ' . $request->id_market . ' tidak ditemukan',
                ]);
            } elseif (empty($validasi_user)) {
                return response()->json([
                    'pesan' => 'data user dengan id ' . $request->id_user . ' tidak ditemukan',
                ]);
            } else {
                $data = marketkomentar::where('id', $request->id)->first();
                $data->id_market = $request->id_market;
                $data->id_user = $request->id_user;
                $data->komentar = $request->komentar;
                $data->save();
                return response()->json([
                    'pesan' => 'data berhasil simpan',
                    'data'  => $data,
                ]);
            }
        }
    }

    function hapuskomentarmarketplaces($id)
    {
        $data = marketkomentar::where('id', $id)->first();
        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            $data->delete();
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' telah dihapus',
            ]);
        }
    }

    function viewmanajemen()
    {
        $data = User::all();

        return response()->json([
            'pesan' => 'data berhasil di ambil',
            'data'  => $data
        ]);
    }
    function viewmanajemenbyid($id)
    {
        $data = User::where('id', $id)->first();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            return response()->json([
                'pesan' => 'data berhasil di ambil',
                'data'  => $data
            ]);
        }
    }

    function hapususer($id)
    {
        $data = User::where('id', $id)->first();

        if (empty($data->id)) {
            return response()->json([
                'pesan' => 'data dengan id ' . $id . ' tidak ditemukan',
            ]);
        } else {
            $data->delete();
            return response()->json([
                'pesan' => 'data berhasil di hapus',
            ]);
        }
    }


    public function editprofil(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response([
                'message' => 'User tidak ditemukan !',
                'data' => null
            ], 400);
        }
        // $user = User::where('id', $request->id)->first();

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|regex:/^[a-zA-Z ]*$/|unique:users,name,' . $id . ',id',
            'email' => 'required|email:rfc,dns',
            'nomor' => 'required|numeric|min:11|regex:/^([0][8][0-9]{8,11})$/u|unique:users,nomor,' . $id . ',id',
        ]);
        if ($validate->fails()) {
            error_log($validate->errors()->first());
            return response(['pesan' => $validate->errors()->first()], 400);
        }

        $user->name = $updateData["name"];
        $user->nomor = $updateData["nomor"];
        $user->email = $updateData["email"];
        if ($updateData["foto"] != null) {
            // $img_name =  $request->file('gambar')->getClientOriginalName() . '-' . time() . '.' . $updateData["foto"]->extension();
            // $updateData["foto"]->move(public_path('foto/upload'), $img_name);
            // $user->gambar = '/foto/upload/' . $img_name;

            $image = $updateData["foto"];  // your base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $replace = substr($image, 0, strpos($image, ',') + 1);
            $image = str_replace($replace, '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . $extension;
            error_log("here");
            // Storage::put(public_path() . '/foto/upload/' . $imageName, base64_decode($image));
            Storage::disk('public')->put($imageName, base64_decode($image));
            $user->foto = $imageName;
        }

        if ($user->save()) {
            return response([
                'pesan' => 'Berhasil update ! Login kembali untuk melihat perubahan',
                'data' => $user
            ], 200);
        }
    }
}
