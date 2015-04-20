<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        $now = date('Y-m-d H:i:s');

        User::create(array(
	        'email' => 'vpa.admin@prasarana.com.my',
            'password' => Hash::make('1q2w3e4r'),
            'activated'  => 1,
            'first_name' => 'Administrator',
            'last_name' => 'System',
            'created_at' => $now,
			'updated_at' => $now
		));
    }

}