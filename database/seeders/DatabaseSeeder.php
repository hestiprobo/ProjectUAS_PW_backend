<?php

namespace Database\Seeders;

use App\Models\marketkomentar;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([KomentarSeeder::class,MarketKomentarSeeder::class,MarketplaceSeeder::class,PostingSeeder::class,UserSeeder::class]);
    }
}
