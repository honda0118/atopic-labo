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
                'name_katakana' => 'アトピタ',
            ],
            [
                'name' => 'アトピコ',
                'name_katakana' => 'アトピコ',
            ],
            [
                'name' => 'キュレル',
                'name_katakana' => 'キュレル',
            ],
            [
                'name' => 'ATOPI SMILE',
                'name_katakana' => 'アトピスマイル',
            ],
            [
                'name' => 'アトピアD',
                'name_katakana' => 'アトピアディー',
            ],
            [
                'name' => 'ケアセラ',
                'name_katakana' => 'ケアセラ',
            ],
            [
                'name' => 'ミルふわ',
                'name_katakana' => 'ミルフワ',
            ],
            [
                'name' => 'セタフィル',
                'name_katakana' => 'セタフィル',
            ],
            [
                'name' => 'イハダ',
                'name_katakana' => 'イハダ',
            ],
            [
                'name' => 'ヘパソフト',
                'name_katakana' => 'ヘパソフト',
            ],
            [
                'name' => 'ハレナ',
                'name_katakana' => 'ハレナ',
            ],
            [
                'name' => 'TIAS',
                'name_katakana' => 'ティアス',
            ],
            [
                'name' => '無添加工房 OKADA',
                'name_katakana' => 'ムテンカコウボオカダ',
            ],
            [
                'name' => 'バイオイル',
                'name_katakana' => 'バイオイル',
            ],
            [
                'name' => '毛穴撫子',
                'name_katakana' => 'ケアナナデシコ',
            ],
            [
                'name' => 'コラージュ',
                'name_katakana' => 'コラージュ',
            ],
            [
                'name' => '咲楽',
                'name_katakana' => 'サクラ',
            ],
            [
                'name' => 'オリヂナル',
                'name_katakana' => 'オリヂナル',
            ],
            [
                'name' => 'sea crystals',
                'name_katakana' => 'シークリスタルス',
            ]
        ]);
    }
}
