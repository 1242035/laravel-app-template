<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name'=>'abcxyz',
        	'email'=>'email@gmail.com',
        	'password'=>bcrypt('123456'),
        ]);
        $faker=Faker\Factory::create();
        for($i=0;$i< 10;$i++){
            DB::table('users')->insert([
            	'name'=>$faker->name(),
                'email'=>$faker->email(),
                'password'=>bcrypt('123456')
            ]);
        }
    }
}
