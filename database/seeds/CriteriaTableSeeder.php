<?php

    use Illuminate\Database\Seeder;
    use App\Models\Criterion;

    class CriteriaTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $defalut_values = [
                [1, 'taste', '味'], [2, 'good_deal', 'コスパ'], [3, 'comfortableness', '居心地'], [4, 'stylishness', 'おしゃれさ'],
                [5, 'equipment', '設備'], [6, 'employee_attitude', 'Staff対応'], [7, 'dactor_attitude', '医師対応'], [8, 'quickness', '迅速さ'],
                [9, 'good_access', 'アクセス'], [10, 'pleasantness', '楽しさ'], [11, 'onsen_quality', 'お湯質'], [12, 'good_view', '景色']
            ];
            foreach ($defalut_values as $item) {
                $criterion = new Criterion();
                $criterion->criterion_id = $item[0];
                $criterion->criterion_name_en = $item[1];
                $criterion->criterion_name_ja = $item[2];
                $criterion->status = 0;
                $criterion->save();
            }
        }
    }
