<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		$users = array(
			array(
				'username' => 'admin',
				'email' => 'admin@example.org',
				'password' => Hash::make('admin'),
				'confirmation_code' => User::confirmationCode(),
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			),
		);

		DB::table('users')->insert( $users );
	}

}
