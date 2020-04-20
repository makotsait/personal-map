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
        Note::create(['user_id'=>1, 'place_id'=>2,'note'=>"■190910マツコの知らない世界\n日本で初めて台湾まぜそばを売り出した店。\nサバ節が食欲を誘う。\nマツコ「あとをひくおいしさ。麺より追い飯のほうが好き。」"]);
    }
}
