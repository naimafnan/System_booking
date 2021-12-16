<?php

namespace Database\Seeders;
use App\Models\Role;
use App\Models\provider;
use App\Models\Services;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        provider::create(['name'=>'Doctor']);
        provider::create(['name'=>'Meeting room']);
        provider::create(['name'=>'Car']);

        Role::create(['name'=>'doctor']);
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'customer']);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => '2',
            'password' => Hash::make('admin@gmail.com'),
          ]);

        Services::create(['name'=>'Fomema Examination','provider_id'=>'1']);
        Services::create(['name'=>'X-ray','provider_id'=>'1']);
        Services::create(['name'=>'Auto','provider_id'=>'3']);
        Services::create(['name'=>'Manual','provider_id'=>'3']);
        Services::create(['name'=>'Discussion','provider_id'=>'2']);
        Services::create(['name'=>'Event','provider_id'=>'2']);

        // Services::create(['provider_id'=>1]);
        // Services::create(['provider_id'=>1]);
        // Services::create(['provider_id'=>3]);
        // Services::create(['provider_id'=>3]);
        // Services::create(['provider_id'=>2]);
        // Services::create(['provider_id'=>2]);

        // DB::table('services')->insert(array (
        //     0 => 
        //       array (
        //              'id' => 1,
        //              'name' => 'Fomema Examination',
        //              'provider_id' => 1,
        //      ),
        //     1 => 
        //       array (
        //              'id' => 2,
        //              'name' => 'X-ray',
        //              'provider_id' => 2,
        //      ),
        //  ));

         
    //   Services::truncate();

    //   $services =  [
    //       [
    //         'name' => 'a',
    //         'provider_id' => 1,
    //       ],
    //       [
    //         'name' => 'b',
    //         'provider_id' => 1,
    //       ],
    //       [
    //         'name' => 'c',
    //         'provider_id' => 3,
    //       ],
    //       [
    //         'name' => 'd',
    //         'provider_id' => 3,
    //       ]
    //     ];

    //     Services::create($services);
    }
}
