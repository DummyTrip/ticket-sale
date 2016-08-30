<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            ['name' => 'TempEvent', 'description' => 'Temp description of event.', 'venue_id' => 1, 'organizer_id' => 1, 'date' => \Carbon\Carbon::now(), 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['name' => 'TempEvent1', 'description' => 'Temp description of event1.', 'venue_id' => 1, 'organizer_id' => 1, 'date' => \Carbon\Carbon::now(), 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        ]);
    }
}
