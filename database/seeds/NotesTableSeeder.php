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
        $defalut_set = [
            [1, 1, 1, 'Hello world!!']
        ];
        foreach ($defalut_set as $item) {
            $note = new Note();
            $note->note_id = $item[0];
            $note->user_id = $item[1];
            $note->place_id = $item[2];
            $note->note = $item[3];
            $note->status = 0;
            $note->save();
        }
    }
}
