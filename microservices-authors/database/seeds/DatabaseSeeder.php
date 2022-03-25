<?php

use App\Models\Author;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // $this->call('UsersTableSeeder');

        factory(Author::class, 50)->create();
    }
}
