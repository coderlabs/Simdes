<?php

class PejabatDesaController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Redirect::to('login');
        }

        return View::make("pejabat.pejabat-desa");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string @term
     * @return Response
     */
    public function read()
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $organisasi_id = Auth::user()->organisasi_id;

        $term = Input::get("term");
        $data = PejabatDesa::where('nama', 'LIKE', '%' . $term . '%')->where('organisasi_id','=',$organisasi_id)->select(['id', 'nama', 'jabatan', 'nomer_sk', 'pejabat', 'tanggal_sk'])->orderBy('id')->paginate(10);
        return Response::json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        // cek apakah dikirim via form ajax
        if (Session::token() !== Input::get('_token')) {
            return Response::json([
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ]);
        }

        // cek validasi
        $rules = [
            'nama'       => 'required|unique:tb_pejabat_desa,nama',
            'jabatan'    => 'required',
            'nomer_sk'   => 'required|unique:tb_pejabat_desa,nomer_sk',
            'judul'      => 'required',
            'pejabat'    => 'required',
            'tanggal_sk' => 'required|date',
        ];

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi gagal
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = [
                'Status'     => 'Warning',
                'nama'       => $messages->first('nama'),
                'jabatan'    => $messages->first('jabatan'),
                'nomer_sk'   => $messages->first('nomer_sk'),
                'judul'      => $messages->first('judul'),
                'pejabat'    => $messages->first('pejabat'),
                'tanggal_sk' => $messages->first('tanggal_sk'),
            ];

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
            // menghilangkan html caracter
            // $kode_rkpdesa  = strip_tags(trim(Input::get('kode_rkpdesa')));
            $nama = strip_tags(trim(Input::get('nama')));
            $jabatan = strip_tags(trim(Input::get('jabatan')));
            $nomer_sk = strip_tags(trim(Input::get('nomer_sk')));
            $judul = strip_tags(trim(Input::get('judul')));
            $pejabat = strip_tags(trim(Input::get('pejabat')));
            $tanggal_sk = strip_tags(trim(Input::get('tanggal_sk')));

            // input
            PejabatDesa::create([
                'nama'       => $nama,
                'jabatan'    => $jabatan,
                'nomer_sk'   => $nomer_sk,
                'judul'      => $judul,
                'pejabat'    => $pejabat,
                'tanggal_sk' => $tanggal_sk,
            ]);

            $user = new User;
            $user->is_pejabat = 1;
            $user->save();



            // set response jika sukses
            $response = [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data berhasil disimpan.',
            ];

            return Response::json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $data = PejabatDesa::find($id);
        if ($data == null) {
            return Redirect::to("pejabat-desa");
        }
        return View::make("pejabat.pejabat-desa")->with('PejabatDesa', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $data = PejabatDesa::find($id);
        $result = [
            'id'         => $data->id,
            'nama'       => $data->nama,
            'jabatan'    => $data->jabatan,
            'nomer_sk'   => $data->nomer_sk,
            'judul'      => $data->judul,
            'pejabat'    => $data->pejabat,
            'tanggal_sk' => $data->tanggal_sk,
        ];

        return Response::json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        // cek apakah dikirim via form ajax
        if (Session::token() !== Input::get('_token')) {
            return Response::json([
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ]);
        }

        // cek validasi
        $rules = [
            'nama'       => 'required',
            'jabatan'    => 'required',
            'nomer_sk'   => 'required',
            'judul'      => 'required',
            'pejabat'    => 'required',
            'tanggal_sk' => 'required|date',
        ];

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi gagal
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = [
                'Status'     => 'Warning',
                'nama'       => $messages->first('nama'),
                'jabatan'    => $messages->first('jabatan'),
                'nomer_sk'   => $messages->first('nomer_sk'),
                'judul'      => $messages->first('judul'),
                'pejabat'    => $messages->first('pejabat'),
                'tanggal_sk' => $messages->first('tanggal_sk'),
            ];

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
            // menghilangkan html caracter
            $nama = strip_tags(trim(Input::get('nama')));
            $jabatan = strip_tags(trim(Input::get('jabatan')));
            $nomer_sk = strip_tags(trim(Input::get('nomer_sk')));
            $judul = strip_tags(trim(Input::get('judul')));
            $pejabat = strip_tags(trim(Input::get('pejabat')));
            $tanggal_sk = strip_tags(trim(Input::get('tanggal_sk')));

            // update
            $data = PejabatDesa::find($id);
            $data->nama = $nama;
            $data->jabatan = $jabatan;
            $data->nomer_sk = $nomer_sk;
            $data->judul = $judul;
            $data->pejabat = $pejabat;
            $data->tanggal_sk = $tanggal_sk;
            $data->save();

            // set response jika sukses
            $response = [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data berhasil diupdate.',
            ];

            return Response::json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        // cek apakah ada relasi atau sedang dipakai
        // $cek = PejabatDesa::all();
        // foreach ($cek as $value) {
        // 	if($value->id_program == $id){
        // 		$response = array(
        // 		'Status' => 'Warning',
        //            'msg' => 'Data dipakai oleh relasi Kegiatan, tidak boleh dihapus!',
        //        );
        //    		return Response::json($response);
        // 	}
        // }

        // jika ada maka tidak boleh dihapus
        // jika tidak dipakai maka boleh dihapus

        $data = PejabatDesa::find($id);
        $data->delete();

        $response = array(
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        );

        return Response::json($response);
    }

}