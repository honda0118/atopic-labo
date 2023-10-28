<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
                'name' => 'アトピタ',
                'katakana' => 'アトピタ',
                'order' => 1,
            ],
            [
                'name' => 'アトピコ',
                'katakana' => 'アトピコ',
                'order' => 2,
            ],
            [
                'name' => 'キュレル',
                'katakana' => 'キュレル',
                'order' => 3,
            ],
        ]);

        DB::table('brands')->insert([
            [
                'name' => 'ATOPI SMILE',
                'katakana' => 'アトピスマイル',
            ],
            [
                'name' => 'アトピアD',
                'katakana' => 'アトピアディー',
            ],
            [
                'name' => 'ケアセラ',
                'katakana' => 'ケアセラ',
            ],
            [
                'name' => 'ミルふわ',
                'katakana' => 'ミルフワ',
            ],
            [
                'name' => 'セタフィル',
                'katakana' => 'セタフィル',
            ],
            [
                'name' => 'イハダ',
                'katakana' => 'イハダ',
            ],
            [
                'name' => 'ヘパソフト',
                'katakana' => 'ヘパソフト',
            ],
            [
                'name' => 'ハレナ',
                'katakana' => 'ハレナ',
            ],
            [
                'name' => 'TIAS',
                'katakana' => 'ティアス',
            ],
            [
                'name' => '無添加工房 OKADA',
                'katakana' => 'ムテンカコウボオカダ',
            ],
            [
                'name' => 'バイオイル',
                'katakana' => 'バイオイル',
            ],
            [
                'name' => '毛穴撫子',
                'katakana' => 'ケアナナデシコ',
            ],
            [
                'name' => 'コラージュ',
                'katakana' => 'コラージュ',
            ],
            [
                'name' => '咲楽',
                'katakana' => 'サクラ',
            ],
            [
                'name' => 'オリヂナル',
                'katakana' => 'オリヂナル',
            ],
            [
                'name' => 'sea crystals',
                'katakana' => 'シークリスタルス',
            ]
        ]);
    }
}
