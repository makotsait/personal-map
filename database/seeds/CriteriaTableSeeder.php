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
            $defalut_set = [
                [1, 'taste', '味'], [2, 'good_deal', 'コスパ'], [3, 'hospitality', '対応'], [4, 'stylishness', 'おしゃれさ'],
                [5, 'quickness', 'スムーズさ'], [6, 'equipment', '設備'], [7, 'comfortableness', '居心地'], [8, 'flexibility', '柔軟さ']
            ];
            foreach ($defalut_set as $item) {
                $criterion = new Criterion();
                $criterion->criterion_id = $item[0];
                $criterion->criterion_name_en = $item[1];
                $criterion->criterion_name_ja = $item[2];
                $criterion->status = 0;
                $criterion->save();
            }
        }
    }
