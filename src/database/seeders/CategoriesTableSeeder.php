<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => '化粧水',
            ],
            [
                'name' => '乳液',
            ],
            [
                'name' => 'オールインワン化粧品',
            ],
            [
                'name' => 'フェイスオイル',
            ],
            [
                'name' => 'シャンプー',
            ],
            [
                'name' => '入浴剤',
            ]
        ]);
    }
}
