<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category as ModelsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Category extends Seeder
{
    
    public function run()
    {
        DB::table('categories')->delete();

        $categories = [
            [
                'name'=>"Breakfast",
                'description'=>"Egyptian and French breakfast"
            ],
            [
                'name'=>"Lunch",
                'description'=>"Chicken and meat, pasta and rice, all kinds of salads and sauces"
            ],
            [
                'name'=>"drinks",
                'description'=>"Hot and cold drinks"
            ],
            [
                'name'=>"dessert",
                'description'=>"Everything is delicious"
            ],
        ];

        ModelsCategory::insert($categories);
    }
           }

