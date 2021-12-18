<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\marketplace;

class MarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Marketplace;
        $data->id = 1;
        $data->id_user = 1;
        $data->title = 'Sepatu Sneakers';
        $data->deskripsi = 'Ini Deskripsi ke '.$data->id;
        $data->foto = '/foto/marketplaces/1.png';
        $data->harga = 1000;
        $data->keterangan = 'available';
        $data->save();
        
        $data = new Marketplace;
        $data->id = 2;
        $data->id_user = 2;
        $data->title = 'Sepatu Sneakers';
        $data->deskripsi = 'Ini Deskripsi ke '.$data->id;
        $data->foto = '/foto/marketplaces/2.jpg';
        $data->harga = 10000;
        $data->keterangan = 'available';
        $data->save();
        
        $data = new Marketplace;
        $data->id = 3;
        $data->id_user = 3;
        $data->title = 'Sepatu Sneakers';
        $data->deskripsi = 'Ini Deskripsi ke '.$data->id;
        $data->foto = '/foto/marketplaces/3.jpg';
        $data->harga = 10000;
        $data->keterangan = 'not available';
        $data->save();
        
        $data = new Marketplace;
        $data->id = 4;
        $data->id_user = 4;
        $data->title = 'Sepatu Sneakers';
        $data->deskripsi = 'Ini Deskripsi ke '.$data->id;
        $data->foto = '/foto/marketplaces/4.jpg';
        $data->harga = 20000;
        $data->keterangan = 'not available';
        $data->save();
        
        $data = new Marketplace;
        $data->id = 5;
        $data->id_user = 5;
        $data->title = 'Sepatu Sneakers';
        $data->deskripsi = 'Ini Deskripsi ke '.$data->id;
        $data->foto = '/foto/marketplaces/5.jpg';
        $data->harga = 20000;
        $data->keterangan = 'not available';
        $data->save();
        


    }
}
