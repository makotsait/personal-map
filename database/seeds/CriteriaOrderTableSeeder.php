<?php

use Illuminate\Database\Seeder;
use App\Models\CriteriaOrder;

class CriteriaOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CriteriaOrder::create(['user_id'=>1, 'place_type_id'=>1,'criterion_id'=>1,'display_order'=>1]);
        CriteriaOrder::create(['user_id'=>1, 'place_type_id'=>1,'criterion_id'=>2,'display_order'=>2]);
        CriteriaOrder::create(['user_id'=>1, 'place_type_id'=>1,'criterion_id'=>6,'display_order'=>3]);
        CriteriaOrder::create(['user_id'=>1, 'place_type_id'=>1,'criterion_id'=>4,'display_order'=>4]);
    }
}
