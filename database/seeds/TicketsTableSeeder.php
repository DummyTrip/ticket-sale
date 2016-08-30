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
        $this->temp(1);
        $this->temp(2);
    }

    public function temp($event_id){
        $tickets = array();

        foreach(range(1,20) as $id) {
            $tickets[] = ['event_id' => $event_id, 'seat_id' => $id, 'price' => 100, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()];
        }

        DB::table('tickets')->insert($tickets);
    }
}
