<?php

class SSHSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$kelas = [
			["kode_kelas" => "", "kelas" => '',]
		];

		foreach ($kelas as $kls) {
            \Simdes\Models\SSH\KelasBarang::create($kls);
		}
	}
}