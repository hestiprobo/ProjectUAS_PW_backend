<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\posting;

class PostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new posting;
        $data->id = 1;
        $data->id_user = 1;
        $data->gambar = '/foto/foto1.jpg';
        $data->caption = 'caption ke '.$data->id;
        $data->save();
        
        $data = new posting;
        $data->id = 2;
        $data->id_user = 2;
        $data->gambar = '/foto/foto2.jpg';
        $data->caption = 'caption ke '.$data->id;
        $data->save();
        
        $data = new posting;
        $data->id = 3;
        $data->id_user = 3;
        $data->gambar = '/foto/foto1.jpg';
        $data->caption = 'caption ke '.$data->id;
        $data->save();
        
        $data = new posting;
        $data->id = 4;
        $data->id_user = 4;
        $data->gambar = '/foto/foto2.jpg';
        $data->caption = 'caption ke '.$data->id;
        $data->save();
        
        $data = new posting;
        $data->id = 5;
        $data->id_user = 5;
        $data->gambar = '/foto/foto1.jpg';
        $data->caption = 'caption ke '.$data->id;
        $data->save();

    }
}
