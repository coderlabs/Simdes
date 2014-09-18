<?php

class UserSeeder extends Seeder
{

    public function run()
    {
        $data = ['David', 'Shinta', 'Atis', 'Slamet', 'Faris', 'Sandi', 'Bayu', 'Suwandi', 'Suwanto', 'Mariono', 'Bayok', 'Baok', 'Kurnia', 'Meiga', 'Bambang'];
        $data1 = ['Prasetiyo', 'Yayuk', 'Hanna', 'Dwi', 'Winda', 'Rahmat', 'Sarmin', 'Fina', 'Sulis', 'Yulis', 'Permata', 'Jingga', 'Yudis', 'Eka', 'Dany'];
        $users = [];
        for ($i = 0; $i < 500; $i++) {
            $acak = array_rand($data);
            $acak1 = array_rand($data1);
            $name = $data[$acak] . ' ' . $data[$acak1];

            $users[] = [
                "name"          => $name,
                "password"      => Hash::make($this->RandomString('abc')),
                "email"         => strtolower($data[$acak]) . '.' . strtolower($data[$acak1]) . '@gmail.com',
                "organisasi_id" => rand(210, 230),
                "is_admin"      => 1,
                "created_at"    => \Carbon\Carbon::now(),
                "is_active"     => 2,
                "kab_id"        => 3507
            ];

        }

        DB::table('users')->insert($users);

    }

    public function RandomString($str)
    {
        return str_shuffle($str);
    }
}