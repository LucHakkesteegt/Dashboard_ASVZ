<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = [
            [
                'name' => 'Sondevoeding1',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding2',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding1',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding2',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding1',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding2',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding1',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding2',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding1',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding2',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Sondevoeding1',
                'created_at' => Carbon::now(),
            ],
        ];

        // Insert the messages into the database
        DB::table('messages')->insert($messages);
    }
}