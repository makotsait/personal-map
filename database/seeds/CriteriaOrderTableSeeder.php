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
        $defalut_set = [
            [1, 1, 1, 1, 1],
            [2, 1, 1, 2, 2],
            [3, 1, 1, 3, 3],
            [4, 1, 1, 4, 4],
        ];
        foreach ($defalut_set as $item) {
            $criteria_order = new CriteriaOrder();
            $criteria_order->criteria_order_id = $item[0];
            $criteria_order->user_id = $item[1];
            $criteria_order->place_type_id = $item[2];
            $criteria_order->criterion_id = $item[3];
            $criteria_order->display_order = $item[4];
            $criteria_order->status = 0;
            $criteria_order->save();
        }
    }
}
