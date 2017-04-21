<?php

use Illuminate\Database\Seeder;
use App\Score;

class ScoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Score::class,10)->create();
    }
}
