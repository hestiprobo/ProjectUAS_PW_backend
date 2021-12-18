<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new User;
        $data->id = 1 ;
        $data->name = 'admin' ;
        $data->email = 'admin@admin.com' ;
        $data->email_verified_at = '2021-11-26 20:54:45' ;
        $data->password = '$2y$10$M0AgXS6F3n9995RHnfpJsO965qZdqMAO0dmOhGPnJ7zgi3j5wxAAy' ;
        $data->role = 'admin';
        $data->foto = 'foto/foto1.jpg' ;
        $data->nomor = 123 ;
        $data->remember_token = null ;
        $data->created_at = '2021-11-26 20:54:11' ;
        $data->updated_at = '2021-11-26 20:54:45' ;
        $data->save();

        $data = new User;
        $data->id = 6 ;
        $data->name = 'Hesti' ;
        $data->email = 'hestiprobodinanti@gmail.com' ;
        $data->email_verified_at = '2021-12-03 19:06:12' ;
        $data->password = '$2y$10$aE8r8tk4K2G4HtCXyISTF.hkFxT8GJp9tFITvQV3jpZ6YUChRBmBS' ;
        $data->role = 'user';
        $data->foto = '/foto/profil/TTD.jpg-1638558906.jpg' ;
        $data->nomor = 123 ;
        $data->remember_token = null ;
        $data->created_at = '2021-12-03 19:05:41' ;
        $data->updated_at = '2021-12-03 19:15:06' ;
        $data->save();    
    }
}
