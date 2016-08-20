<?php

use Illuminate\Database\Seeder;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seats = array();
        $seat_venue = array();

        foreach(range(1,2) as $row) {
            foreach(range(1,10) as $column) {
                $seats[] = ['row' => $row, 'column' => $column, 'block' => $row,'block_name' => 'row' ,'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()];
            }
        }

        foreach(range(1,20) as $id) {
            $seat_venue[] = ['seat_id' => $id, 'venue_id' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()];
        }


        DB::table('seats')->insert($seats);
        DB::table('seat_venue')->insert($seat_venue);
    }
}
