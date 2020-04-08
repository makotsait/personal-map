<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            CriteriaOrderTableSeeder::class,
            CriteriaTableSeeder::class,
            NotesTableSeeder::class,
            PlacesTableSeeder::class,
            PlaceTypesTableSeeder::class,
            RatingsTableSeeder::class,
        ]);
    }
}
