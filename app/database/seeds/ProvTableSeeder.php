<?php

class ProvTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$prov = [
			['kode_prov' => '11', 'prov' => 'Aceh'],
			['kode_prov' => '12', 'prov' => 'Sumatera Utara'],
			['kode_prov' => '13', 'prov' => 'Sumatera Barat'],
			['kode_prov' => '14', 'prov' => 'Riau'],
			['kode_prov' => '15', 'prov' => 'Jambi'],
			['kode_prov' => '16', 'prov' => 'Sumatera Selatan'],
			['kode_prov' => '17', 'prov' => 'Bengkulu'],
			['kode_prov' => '18', 'prov' => 'Lampung'],
			['kode_prov' => '19', 'prov' => 'Kep. Bangka Belitung'],
			['kode_prov' => '21', 'prov' => 'Kep. Riau'],
			['kode_prov' => '31', 'prov' => 'DKI Jakarta'],
			['kode_prov' => '32', 'prov' => 'Jawa Barat'],
			['kode_prov' => '33', 'prov' => 'Jawa Tengah'],
			['kode_prov' => '34', 'prov' => 'DI Yogyakarta'],
			['kode_prov' => '35', 'prov' => 'Jawa Timur'],
			['kode_prov' => '36', 'prov' => 'Banten'],
			['kode_prov' => '51', 'prov' => 'Bali'],
			['kode_prov' => '52', 'prov' => 'Nusa Tenggara Barat'],
			['kode_prov' => '53', 'prov' => 'Nusa Tenggara Timur'],
			['kode_prov' => '61', 'prov' => 'Kalimantan Barat'],
			['kode_prov' => '62', 'prov' => 'Kalimantan Tengah'],
			['kode_prov' => '63', 'prov' => 'Kalimantan Selatan'],
			['kode_prov' => '64', 'prov' => 'Kalimantan Timur'],
			['kode_prov' => '71', 'prov' => 'Sulawesi Utara'],
			['kode_prov' => '72', 'prov' => 'Sulawesi Tengah'],
			['kode_prov' => '73', 'prov' => 'Sulawesi Selatan'],
			['kode_prov' => '74', 'prov' => 'Sulawesi Tenggara'],
			['kode_prov' => '75', 'prov' => 'Gorontalo'],
			['kode_prov' => '76', 'prov' => 'Sulawesi Barat'],
			['kode_prov' => '81', 'prov' => 'Maluku'],
			['kode_prov' => '82', 'prov' => 'Maluku Utara'],
			['kode_prov' => '91', 'prov' => 'Papua Barat'],
			['kode_prov' => '94', 'prov' => 'Papua']
		];

		DB::table('tb_master_prov')->insert($prov);
	}

}