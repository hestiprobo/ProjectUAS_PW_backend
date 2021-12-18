<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\marketkomentar;

class MarketKomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data  = new  marketkomentar;
        $data->id = 1;
        $data->id_user = 1;
        $data->id_market = 1;
        $data->komentar = 'komentar '.$data->id;
        $data->save();
        
        $data  = new  marketkomentar;
        $data->id = 2;
        $data->id_user = 2;
        $data->id_market = 2;
        $data->komentar = 'komentar '.$data->id;
        $data->save();
        
        $data  = new  marketkomentar;
        $data->id = 3;
        $data->id_user = 3;
        $data->id_market = 3;
        $data->komentar = 'komentar '.$data->id;
        $data->save();
        
        $data  = new  marketkomentar;
        $data->id = 4;
        $data->id_user = 4;
        $data->id_market = 4;
        $data->komentar = 'komentar '.$data->id;
        $data->save();
        
        $data  = new  marketkomentar;
        $data->id = 5;
        $data->id_user = 5;
        $data->id_market = 5;
        $data->komentar = 'komentar '.$data->id;
        $data->save();
        
    }
}
