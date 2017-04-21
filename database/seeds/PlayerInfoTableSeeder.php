<?php

use Illuminate\Database\Seeder;
use App\PlayerInfo;

class PlayerInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PlayerInfo::class,10)->create();
    }
}
