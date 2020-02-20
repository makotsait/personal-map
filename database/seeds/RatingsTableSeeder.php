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
        $defalut_set = [
            [1, 1, 1, 1, 1], [2, 1, 1, 2, 2], [3, 1, 1, 3, 3], [4, 1, 1, 4, 4]
        ];
        foreach ($defalut_set as $item) {
            $rating = new Rating();
            $rating->rating_id = $item[0];
            $rating->user_id = $item[1];
            $rating->place_id = $item[2];
            $rating->criterion_id = $item[3];
            $rating->rating = $item[4];
            $rating->status = 0;
            $rating->save();
        }
    }
}
