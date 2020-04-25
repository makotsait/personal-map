<?php

use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::create(['user_id'=>1, 'place_id'=>1,'criterion_id'=>1,'rating'=>5]);
        Rating::create(['user_id'=>1, 'place_id'=>1,'criterion_id'=>2,'rating'=>5]);
        Rating::create(['user_id'=>1, 'place_id'=>1,'criterion_id'=>6,'rating'=>4]);
        Rating::create(['user_id'=>1, 'place_id'=>1,'criterion_id'=>4,'rating'=>3]);
        Rating::create(['user_id'=>2, 'place_id'=>2,'criterion_id'=>1,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>2,'criterion_id'=>2,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>2,'criterion_id'=>6,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>2,'criterion_id'=>4,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>3,'criterion_id'=>1,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>3,'criterion_id'=>2,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>3,'criterion_id'=>6,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>3,'criterion_id'=>4,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>4,'criterion_id'=>1,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>4,'criterion_id'=>2,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>4,'criterion_id'=>6,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>4,'criterion_id'=>4,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>5,'criterion_id'=>1,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>5,'criterion_id'=>2,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>5,'criterion_id'=>6,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>5,'criterion_id'=>4,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>6,'criterion_id'=>1,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>6,'criterion_id'=>2,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>6,'criterion_id'=>6,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>6,'criterion_id'=>4,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>7,'criterion_id'=>1,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>7,'criterion_id'=>2,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>7,'criterion_id'=>6,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>7,'criterion_id'=>4,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>8,'criterion_id'=>1,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>8,'criterion_id'=>2,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>8,'criterion_id'=>6,'rating'=>0]);
        Rating::create(['user_id'=>2, 'place_id'=>8,'criterion_id'=>4,'rating'=>0]);
    }
}
