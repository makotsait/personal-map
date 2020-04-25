<?php

use Illuminate\Database\Seeder;
use App\Models\Note;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Note::create(['user_id'=>1, 'place_id'=>1,'note'=>'Hello world!!']);
        Note::create(['user_id'=>2, 'place_id'=>2,'note'=>"■190910マツコの知らない世界\n日本で初めて台湾まぜそばを売り出した店。\nサバ節が食欲を誘う。\nマツコ「あとをひくおいしさ。麺より追い飯のほうが好き。」"]);
        Note::create(['user_id'=>2, 'place_id'=>3,'note'=>"■190910マツコの知らない世界\nおすすめは台湾まぜそばZ。\n唐辛子の辛さがやみつきになる。"]);
        Note::create(['user_id'=>2, 'place_id'=>4,'note'=>"■190910マツコの知らない世界\n新潟からとりよせた極太麺。\n醤油ベースのタレと、ラー油、一味唐辛子を絡める。\n岩のり。味噌味のミンチ。\n紹介者は台湾まぜそば鬼油を推すが、こってりすぎるので自分が頼むなら標準的なもののほうがよさそう。"]);
        Note::create(['user_id'=>2, 'place_id'=>5,'note'=>"■190910マツコの知らない世界\nまつこの知らない世界にて「ストロング系で一番オススメの台湾まぜそば」として紹介。\n紹介者のレビューで満点。\nおすすめは「男山台湾まぜそば」。\n極太麺。もやし、九条ネギ、ミンチ、卵黄が添えられていておいしそう。\nマツコ「背脂たっぷりだが、もやしで調和して食べやすい。」"]);
        Note::create(['user_id'=>2, 'place_id'=>6,'note'=>"■190910マツコの知らない世界\nヘルシーな混ぜそば。\n鳥のミンチ、削り節、揚げナス、トマトのマリネなど。\n女性受けの良いメニューあり。"]);
        Note::create(['user_id'=>2, 'place_id'=>7,'note'=>"■190910マツコの知らない世界\n油を抑えたマイルドな混ぜそば。\n麺がもちもち。\nおすすめはバター台湾混ぜそば。"]);
        Note::create(['user_id'=>2, 'place_id'=>8,'note'=>"■190910マツコの知らない世界\nミックスチーズ入りのタレに極太麺が絡んで美味しい。\nマツコ「チーズが邪魔しなくておいしい」"]);
    }
}
