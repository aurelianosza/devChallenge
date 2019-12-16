<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{

    public function run(){
         $this->call([CategoryTableSeeder::class]);
    }
}
