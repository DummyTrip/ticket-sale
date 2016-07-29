<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(VenuesTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(SeatsTableSeeder::class);

        Model::reguard();
    }
}
