<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('ItemsTableSeeder');
		$this->call('SectionsTableSeeder');
		$this->call('RoomsTableSeeder');
		$this->call('ContainersTableSeeder');
	}

}