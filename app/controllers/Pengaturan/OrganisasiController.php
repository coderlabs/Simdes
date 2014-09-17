<?php
namespace Pengaturan;

class OrganisasiController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // cek apakah sudah login
        if (!\Auth::check()) {
            return \Redirect::to('login');
        }

        $organisasi_id = \Auth::user()->organisasi_id;

        $data = \Organisasi::find($organisasi_id);

        return \View::make("pages.organisasi")->with('organisasi', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \Illuminate\Support\Facades\Redirect::to('organisasi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return \Illuminate\Support\Facades\Redirect::to('organisasi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return \Illuminate\Support\Facades\Redirect::to('organisasi');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return \Illuminate\Support\Facades\Redirect::to('organisasi');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        // cek apakah sudah login
        if (!\Auth::check()) {
            return \Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        // cek apakah dikirim via form ajax
        if (\Session::token() !== \Input::get('_token')) {
            return \Response::json([
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ]);
        }

        // cek validasi
        $rules = [
            'nama'      => 'required',
            'alamat'    => 'required',
            'kode_desa' => 'required',
            'desa'      => 'required',
            'kode_kec'  => 'required',
            'kode_kab'  => 'required',
            'kode_prov' => 'required',
            'no_telp'   => 'required',
            'email'     => 'required',
        ];

        $validator = \Validator::make(\Input::all(), $rules);

        // kirim data jika validasi gagal
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = [
                'Status'    => 'Warning',
                'nama'      => $messages->first('nama'),
                'alamat'    => $messages->first('alamat'),
                'kode_desa' => $messages->first('kode_desa'),
                'desa'      => $messages->first('desa'),
                'kode_kec'  => $messages->first('kode_kec'),
                'kode_kab'  => $messages->first('kode_kab'),
                'kode_prov' => $messages->first('kode_prov'),
                'no_telp'   => $messages->first('no_telp'),
                'email'     => $messages->first('email'),
            ];

            return \Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
            // menghilangkan html caracter
            $nama = e(\Input::get('nama'));
            $alamat = e(\Input::get('alamat'));
            $kode_desa = e(\Input::get('kode_desa'));
            $desa = e(\Input::get('desa'));
            $kec = e(\Input::get('kec'));
            $kode_kec = e(\Input::get('kode_kec'));
            $kode_prov = e(\Input::get('kode_prov'));
            $no_telp = e(\Input::get('no_telp'));
            $fax = e(\Input::get('fax'));
            $email = e(\Input::get('email'));
            $kode_kab = \input::get('kode_kab');

            $getKab = \Kabupaten::where('kode_kab', '=', $kode_kab)->first();
            $kab = $getKab->kab;
            $getProv = \Provinsi::where('kode_prov', '=', $kode_prov)->first();
            $prov = $getProv->prov;

            // input
            $data = \Organisasi::find(\Auth::user()->organisasi_id);
            $data->nama = $nama;
            $data->alamat = $alamat;
            $data->kode_desa = $kode_desa;
            $data->desa = $desa;
            $data->kec = $kec;
            $data->kab = $kab;
            $data->kode_kec = $kode_kec;
            $data->kode_kab = $kode_kab;
            $data->kode_prov = $kode_prov;
            $data->prov = $prov;
            $data->no_telp = $no_telp;
            $data->fax = $fax;
            $data->email = $email;
            $data->save();

            $org = \User::find(\Auth::user()->id);
            $org->is_organisasi = 1;
            $org->save();

            // set response jika sukses
            $response = [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data berhasil diupdate.',
            ];

            return \Response::json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return \Illuminate\Support\Facades\Redirect::to('organisasi');
    }

}