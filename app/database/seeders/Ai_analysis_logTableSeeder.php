<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Ai_analysis_logTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'image_path' => 'test',
            'success' => 'true',
            'message' => 'メッセージです',
            'class' => 3,
            'confidence' => 3.2,
            'request_timestamp' => 123,
            'response_timestamp' => 456,
        ];
        DB::table('ai_analysis_log')->insert($param);
    }
}
