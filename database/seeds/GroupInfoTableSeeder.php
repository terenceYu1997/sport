<?php

use Illuminate\Database\Seeder;
use App\GroupInfo;

class GroupInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(GroupInfo::class, 10)->create();
    }
}
