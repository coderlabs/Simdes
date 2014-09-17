<?php

/**
 * Class AjaxController
 */
class AjaxController extends \BaseController
{

    /**
     * menampilkan data
     *
     * @return Response
     */
    public function sumberDana()
    {
        // $term = Input::get('program');
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        // get dropdown sumberdana
        // untuk RPJMDesa -> Masalah -> Program
        // note : nanti akan evaluasi lagi
        $data = DB::table('tb_akun_kelompok_1')->where('akun_id', '=', '1')->get(['id', 'kelompok as sumber_dana']);

        if (null != $data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'          => $value->id,
                    'sumber_dana' => substr($value->sumber_dana, 0, 70)
                ];
            }
        } else {
            $result[] = "";
        }


        return Response::json($result);
    }

    /**
     * Ajax dropdown Provinsi
     *
     * @param
     *
     * @return Response
     */
    public function ajaxProv()
    {
        // $term = Input::get('program');
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $data = Provinsi::get();
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'kode_prov' => $value->kode_prov,
                    'prov'      => $value->prov,
                ];
            }
        } else {
            $result[] = "";
        }

        return Response::json($result);
    }

    /**
     * Ajax dropdown Kabupaten
     *
     * @param int $kode_prov
     *
     * @return Response
     */
    public function ajaxKab($kode_prov)
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        // $kode_prov = Input::get('kode_prov');
        $data = Kabupaten::where('kode_prov', '=', $kode_prov)->get();
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'kode_kab' => $value->kode_kab,
                    'kab'      => $value->status . " " . $value->kab,
                ];
            }
        } else {
            $result[] = "";
        }

        return Response::json($result);
    }

    /**
     * Ajax dropdown Kecamatan
     *
     * @param int $kode_kab
     *
     * @return Response
     */
    public function ajaxKec($kode_kab)
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $data = Kecamatan::where('kode_kab', '=', $kode_kab)->get();
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'kode_kec' => $value->kode_kec,
                    'kec'      => $value->kec
                ];
            }
        } else {
            $result[] = "";
        }

        return Response::json($result);
    }

    /**
     * Ajax dropdown Desa
     *
     * @param int $kode_kec
     *
     * @return Response
     */
    public function ajaxDesa($kode_kec)
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $data = Desa::where('kode_kec', '=', $kode_kec)->get();
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'kode_desa' => $value->kode_desa,
                    'desa'      => $value->status . " " . $value->desa,
                ];
            }
        } else {
            $result[] = "";
        }

        return Response::json($result);
    }


    /**
     * Ajax dropdown Pejabat Desa
     *
     * @param int $kode_kec
     *
     * @return Response
     */
    public function ajaxPejabatDesa()
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $data = PejabatDesa::get();
        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'           => $value->id,
                    'pejabat_desa' => $value->nama . " - " . $value->jabatan,
                ];
            }
        } else {
            $result[] = "";
        }

        return Response::json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy()
    {
        //
    }

}