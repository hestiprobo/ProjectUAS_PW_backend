<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\komentar;

class KomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new komentar;
        $data -> id = 1;
        $data -> id_user = 2;
        $data -> id_post = 1;
        $data -> komentar = 'komentar dari user ' . $data->id_user;
        $data-> created_at = '2021-11-27 22:17:58';
        $data->save();

        $data = new komentar;
        $data -> id = 2;
        $data -> id_user = 3;
        $data -> id_post = 2;
        $data -> komentar = 'komentar dari user ' . $data->id_user;
        $data-> created_at = '2021-11-27 22:18:11';
        $data->save();

        $data = new komentar;
        $data -> id = 3;
        $data -> id_user = 4;
        $data -> id_post = 3;
        $data -> komentar = 'komentar dari user ' . $data->id_user;
        $data-> created_at = '2021-11-27 22:18:11';
        $data->save();

        $data = new komentar;
        $data -> id = 4;
        $data -> id_user = 5;
        $data -> id_post = 4;
        $data -> komentar = 'komentar dari user ' . $data->id_user;
        $data-> created_at = '2021-11-27 22:18:11';
        $data->save();

        $data = new komentar;
        $data -> id = 5;
        $data -> id_user = 1;
        $data -> id_post = 5;
        $data -> komentar = 'komentar dari user ' . $data->id_user;
        $data-> created_at = '2021-11-27 22:18:11';
        $data->save();

    }
}
