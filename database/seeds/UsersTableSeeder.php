<?php

use Illuminate\Database\Seeder;

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
            'firstname' => 'Саня',
            'lastname' => 'Шейкин',
            'email' => '6125131@vk.com',
			'password' => bcrypt(str_random(20)),
			'vk_id' => '6125131'
        ]);
		
        DB::table('users')->insert([
            'firstname' => 'Test',
            'lastname' => 'Test',
            'email' => 'test@test.com',
			'password' => bcrypt('testtest'),
			'vk_id' => 0
        ]);		
    }
}
