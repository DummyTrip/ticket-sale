<?php

use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tickets = array();

        foreach(range(1,19) as $id) {
            $tickets[] = ['event_id' => 1, 'seat_id' => $id, 'price' => 100, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()];
        }

        DB::table('tickets')->insert($tickets);
        DB::table('tickets')->insert([
            'event_id' => 1, 'seat_id' => 20, 'price' => 200, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
