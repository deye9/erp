<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        Model::unguard();

        // Register the user seeder
        // $this->call('UsersTableSeeder');
        // $this->call(UsersTableSeeder::class);
        // $this->call(ProductsTableSeeder::class);

        Model::reguard();
    }
}
