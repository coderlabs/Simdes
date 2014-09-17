<?php

class AkunSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//            $akuns = [
//                   ['kode_rekening' =>  '1', 'akun' => 	'Pendapatan'],
//                   ['kode_rekening' =>  '2', 'akun' => 	'Belanja'],
//                   ['kode_rekening' =>  '2', 'akun' => 	'Pembiayaan']
//            ];
//
//            foreach ($akuns as $akun) {
//                \Simdes\Models\Akun\Akun::create($akun);
//            }
//
//            $kelompoks = [
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.1' , 'kelompok' => 'Pendapatan Asli Desa' ],
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.2' , 'kelompok' => 'Alokasi APBN' ],
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.3' , 'kelompok' => 'Bagian Hasil Pajak dan Retribusi Daerah:' ],
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.4' , 'kelompok' => 'Bagian Dana Perimbangan Pusat dan Daerah' ],
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.5' , 'kelompok' => 'Bantuan Keuangan Pemerintah Provinsi, Kabupaten/Kota, dan desa lainnya' ],
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.6' , 'kelompok' => 'Hibah' ],
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.7' , 'kelompok' => 'Sumbangan Pihak Ketiga' ],
//                [ 'akun_id' =>  '1', 'kode_rekening' =>	'1.8' , 'kelompok' => 'Lain-lain Pendapatan Asli Desa yang Sah' ],
//                [ 'akun_id' =>  '2', 'kode_rekening' =>	'2.1' , 'kelompok' => 'Belanja Langsung' ],
//                [ 'akun_id' =>  '2', 'kode_rekening' =>	'2.2' , 'kelompok' => 'Belanja Tidak Langsung' ],
//                [ 'akun_id' =>  '3', 'kode_rekening' =>	'3.1' , 'kelompok' => 'Penerimaan Pembiayaan' ],
//                [ 'akun_id' =>  '3', 'kode_rekening' =>	'3.2' , 'kelompok' => 'Pengeluaran Pembiayaan' ],
//
//            ];
//
//            foreach ($kelompoks as $kelompok) {
//                \Simdes\Models\Akun\Kelompok::create($kelompok);
//            }
//
//            $jeniss = [
//                ['kelompok_id' => '1', 'kode_rekening' => '1.1.1', 'jenis' => '	Hasil Usaha Desa'],
//                ['kelompok_id' => '1', 'kode_rekening' => '1.1.2', 'jenis' => '	Hasil Pengelolaan Aset Desa'],
//                ['kelompok_id' => '1', 'kode_rekening' => '1.1.3', 'jenis' => '	Hasil Swadaya dan Partisipasi'],
//                ['kelompok_id' => '1', 'kode_rekening' => '1.1.4', 'jenis' => '	Hasil Gotong Royong'],
//                ['kelompok_id' => '1', 'kode_rekening' => '1.1.5', 'jenis' => '	Lain-lain Pendapatan Asli Desa yang sah'],
//                ['kelompok_id' => '3', 'kode_rekening' => '1.3.1', 'jenis' => '	Bagian hasil pajak daerah kabupaten/kota'],
//                ['kelompok_id' => '3', 'kode_rekening' => '1.3.2', 'jenis' => '	Bagian hasil retribusi daerah'],
//                ['kelompok_id' => '4', 'kode_rekening' => '1.4.1', 'jenis' => '	ADD Kegiatan Pemerintahan'],
//                ['kelompok_id' => '4', 'kode_rekening' => '1.4.2', 'jenis' => '	ADD Kegiatan Pemberdayaan'],
//                ['kelompok_id' => '5', 'kode_rekening' => '1.5.1', 'jenis' => '	Bantuan Keuangan Pemerintah:'],
//                ['kelompok_id' => '5', 'kode_rekening' => '1.5.2', 'jenis' => '	Bantuan Keuangan Pemerintah Provinsi'],
//                ['kelompok_id' => '5', 'kode_rekening' => '1.5.3', 'jenis' => '	Bantuan Keuangan Pemerintah Kabupaten/Kota.'],
//                ['kelompok_id' => '5', 'kode_rekening' => '1.5.4', 'jenis' => '	Bantuan Keuangan Desa lainnya :'],
//                ['kelompok_id' => '6', 'kode_rekening' => '1.6.1', 'jenis' => '	Hibah dari pemerintah'],
//                ['kelompok_id' => '6', 'kode_rekening' => '1.6.2', 'jenis' => '	Hibah dari pemerintah provinsi'],
//                ['kelompok_id' => '6', 'kode_rekening' => '1.6.3', 'jenis' => '	Hibah dari pemerintah kabupaten/kota'],
//                ['kelompok_id' => '6', 'kode_rekening' => '1.6.4', 'jenis' => '	Hibah dari badan/lembaga/organisasi swasta'],
//                ['kelompok_id' => '6', 'kode_rekening' => '1.6.5', 'jenis' => '	Hibah dari kelompok masyarakat/ perorangan'],
//                ['kelompok_id' => '7', 'kode_rekening' => '1.7.1', 'jenis' => '	Sumbangan dari warga'],
//                ['kelompok_id' => '8', 'kode_rekening' => '1.8.1', 'jenis' => '	Pungutan'],
//                ['kelompok_id' => '9', 'kode_rekening' => '2.1.1', 'jenis' => '	Belanja Pegawai/Honorarium :'],
//                ['kelompok_id' => '9', 'kode_rekening' => '2.1.2', 'jenis' => '	Belanja Barang/Jasa :'],
//                ['kelompok_id' => '9', 'kode_rekening' => '2.1.3', 'jenis' => '	Belanja Modal'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '2.2.1', 'jenis' => '	Belanja Pegawai/Penghasilan Tetap'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '2.2.3', 'jenis' => '	Belanja Hibah'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '2.2.4', 'jenis' => '	Belanja Bantuan Sosial :'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '2.2.5', 'jenis' => '	Belanja Bantuan Keuangan'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '2.2.6', 'jenis' => '	Belanja tak terduga'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '3.1.1', 'jenis' => '	Sisa Lebih Perhitungan Anggaran (SILPA) tahun sebelumnya.'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '3.1.2', 'jenis' => '	Hasil penjualan kekayaan Desa yang dipisahkan.'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '3.1.3', 'jenis' => '	Penerimaan Pinjaman'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '3.2.1', 'jenis' => '	Pembentukan Dana Cadangan'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '3.2.2', 'jenis' => '	Penyertaan Modal Desa'],
//                ['kelompok_id' => '1', 'kode_rekening' =>  '3.2.3', 'jenis' => '	Pembayaran utang'],
//
//            ];
//
//            foreach ($jeniss as $jenis) {
//                \Simdes\Models\Akun\Jenis::create($jenis);
//            }
//
//            $obyeks = [
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.2', 'obyek' =>	'Tanah Ulayat'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.3', 'obyek' =>	'Pasar Desa'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.4', 'obyek' =>	'Pasar Hewan'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.5', 'obyek' =>	'Tambatan Perahu'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.6', 'obyek' =>	'Bangunan Desa'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.8', 'obyek' =>	'Pelelangan Ikan yang dikelola Desa'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.9', 'obyek' =>	'Pelelangan Hasil Pertanian'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.10', 'obyek' =>	'Hutan Milik Desa'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.11', 'obyek' =>	'Mata Air Milik Desa'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.13', 'obyek' =>	'Pemandian Umum'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '2', 'kode_rekening' => '1.1.2.14', 'obyek' =>	'Lain-lain Aset Milik Desa'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '6', 'kode_rekening' => '1.3.1.1', 'obyek' =>	'Bagian hasil PBB'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '7', 'kode_rekening' => '1.3.2.1', 'obyek' =>	'Bagian hasil retribusi parkir'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '12', 'kode_rekening' => '1.5.3.1', 'obyek' =>	'Dana Tambahan penghasilan tetap Kepala Desa dan Perangkat Desa'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '21', 'kode_rekening' => '2.1.1.1', 'obyek' =>	'Honor tim/panitia'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '22', 'kode_rekening' => '2.1.2.1', 'obyek' =>	'Belanja perjalanan dinas'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '22', 'kode_rekening' => '2.1.2.2', 'obyek' =>	'Belanja bahan/material'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '23', 'kode_rekening' => '2.1.3.1', 'obyek' =>	'Belanja Modal Tanah'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '23', 'kode_rekening' => '2.1.3.2', 'obyek' =>	'Belanja Modal jaringan'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '26', 'kode_rekening' => '2.2.4.1', 'obyek' =>	'Pendidikan Anak Usia Dini (PAUD)'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '28', 'kode_rekening' => '2.2.6.1', 'obyek' =>	'Keadaan darurat'],
//                [ 'regulasi' => '','tanggal' => '0000-00-00', 'pengundangan' => '', 'jenis_id' => '28', 'kode_rekening' => '2.2.6.2', 'obyek' =>	'Bencana alam'],
//
//            ];
//
//            foreach ($obyeks as $obyek) {
//                \Simdes\Models\Akun\Obyek::create($obyek);
//            }

        $kewenangans = [
            ['kode_rekening' => '1', 'kewenangan' => 'Kewenangan Desa berdasarkan Hak Asal-Usul'],
            ['kode_rekening' => '2', 'kewenangan' => 'Kewenangan Lokal Berskala Desa'],
            ['kode_rekening' => '3', 'kewenangan' => 'Kewenangan yang ditugaskan oleh Pemerintah'],
            ['kode_rekening' => '4', 'kewenangan' => 'Kewenangan yang ditugaskan oleh Pemerintah Daerah Provinsi'],
            ['kode_rekening' => '5', 'kewenangan' => 'Kewenangan yang ditugaskan oleh Pemerintah Daerah Kabupaten/Kota'],
            ['kode_rekening' => '6', 'kewenangan' => 'Kewenangan lain yang ditugaskan oleh Pemerintah sesuai dengan ketentuan Peraturan Perundang-undangan'],
            ['kode_rekening' => '7', 'kewenangan' => 'Kewenangan lain yang ditugaskan oleh Pemerintah Daerah Provinsi sesuai dengan ketentuan Peraturan Perundang-undangan'],
            ['kode_rekening' => '8', 'kewenangan' => 'Kewenangan lain yang ditugaskan oleh Pemerintah Daerah Kabupaten/Kota sesuai dengan ketentuan Peraturan Perundang-undangan'],
        ];

        foreach ($kewenangans as $kewenangan) {
            Simdes\Models\Kewenangan\Kewenangan::create($kewenangan);
//                Kewenangan::create($obyek);
        }

        $bidang_kewenangans = [
            ['kewenangan_id' => '1', 'kode_rekening' => '1.1', 'bidang' => 'sistem organisasi masyarakat adat;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '1', 'kode_rekening' => '1.2', 'bidang' => 'pembinaan kelembagaan masyarakat;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '1', 'kode_rekening' => '1.3', 'bidang' => 'pembinaan lembaga dan hukum adat;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '1', 'kode_rekening' => '1.4', 'bidang' => 'pengelolaan tanah kas Desa;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '1', 'kode_rekening' => '1.5', 'bidang' => 'pengembangan peran masyarakat Desa', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.1', 'bidang' => 'pengelolaan tambatan perahu;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.2', 'bidang' => 'pengelolaan pasar Desa;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.3', 'bidang' => 'pengelolaan tempat pemandian umum; ', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.4', 'bidang' => 'pengelolaan jaringan irigasi;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.5', 'bidang' => 'pengelolaan lingkungan permukiman masyarakat Desa; ', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.6', 'bidang' => 'pembinaan kesehatan masyarakat dan pengelolaan pos pelayanan terpadu; ', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.7', 'bidang' => 'pengembangan dan pembinaan sanggar seni dan belajar; ', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.8', 'bidang' => 'pengelolaan perpustakaan Desa dan taman bacaan; ', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.9', 'bidang' => 'pengelolaan embung Desa;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.10', 'bidang' => 'pengelolaan air minum berskala Desa;', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],
            ['kewenangan_id' => '2', 'kode_rekening' => '2.11', 'bidang' => 'pembuatan jalan Desa antarpermukiman ke wilayah pertanian. ', 'regulasi' => 'Peraturan Pemerintah Nomor 43 Tahun 2014 tentang Peraturan Pelaksanaan Undang-Undang Nomor 6 Tahun 2014 tentang Desa', 'tanggal' => '2014-05-30', 'pengundangan' => 'Lembaran Negara Republik Indonesia Tahun 2014 Nomor 123'],

        ];

        foreach ($bidang_kewenangans as $bidang) {
            Simdes\Models\Kewenangan\Bidang::create($bidang);
        }

    }
}