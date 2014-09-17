<?php

class KegiatanController extends \BaseController
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
        return View::make("kewenangan.kegiatan");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $term
     * @return Response
     */
    public function read()
    {
        $term = Input::get('term');
        $data = DB::table('tb_kegiatan')
            ->join('tb_program', 'tb_program.id', '=', 'tb_kegiatan.id_program')
            ->select('tb_kegiatan.id', 'tb_program.program', 'kode_kegiatan', 'kegiatan')
            ->where('kegiatan', 'LIKE', '%' . $term . '%')
            ->orderBy('kode_kegiatan')
            ->paginate(10);

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
            return Response::json(array(
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ));
        }

        // cek validasi
        $rules = [
            'program'       => 'required|numeric',
            'kode_kegiatan' => 'required|unique:tb_kegiatan,kode_kegiatan',
            'kegiatan'      => 'required|unique:tb_kegiatan,kegiatan',
        ];

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi gagal
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = [
                'Status'        => 'Warning',
                'program'       => $messages->first('program'),
                'kode_kegiatan' => $messages->first('kode_kegiatan'),
                'kegiatan'      => $messages->first('kegiatan')
            ];

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
            // menghilangkan html caracter

            $program = strip_tags(trim(Input::get('program')));
            $kode_kegiatan = strip_tags(trim(Input::get('kode_kegiatan')));
            $kegiatan = strip_tags(trim(Input::get('kegiatan')));

            // huruf besar pada awal kata
            // $kewenangan = ucwords(strtolower($kewenangan));

            // masukkan data jika validasi sukses
            Kegiatan::create([
                'id_program'    => $program,
                'kode_kegiatan' => $kode_kegiatan,
                'kegiatan'      => $kegiatan
            ]);

            // set response jika sukses
            $response = [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data berhasil disimpan.',
            ];

            return Response::json($response);
        }
    }

    /**
     * menampilkan data kewenangan
     *
     * @return Response Json
     */
    public function ajax()
    {
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }

        $data = Program::get();
        foreach ($data as $value) {
            $result[] = array(
                'id'      => $value->id,
                'program' => substr($value->program, 0, 70)
            );
        }
        return Response::json($result);
    }

    /**
     * menampilkan data kegiatan
     *
     * @param int $term
     * @return Response Json
     */
    public function ajaxKegiatan($term)
    {
        // $term = Input::get('program');
        // cek apakah sudah login
        if (!Auth::check()) {
            return Response::json([
                'Status' => 'Logout',
                'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
            ]);
        }


        $data = DB::table('tb_kegiatan')
            ->where('id_program', '=', $term)
            ->get(['id', 'kegiatan']);

        $result = [];
        if ($data) {
            foreach ($data as $value) {
                $result[] = [
                    'id'       => $value->id,
                    'kegiatan' => $value->kegiatan
                ];
            }
        } else {
            $result[] = '';
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $data = Kegiatan::find($id);
        if ($data == null) {
            return Redirect::to("kegiatan");
        } else {
            return Redirect::to("kegiatan");
        }
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

        return Response::json(Kegiatan::find($id));
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
            return Response::json(array(
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ));
        }

        // cek validasi
        $rules = [
            'program'       => 'required|integer',
            'kode_kegiatan' => 'required',
            'kegiatan'      => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi gagal
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = [
                'Status'        => 'Warning',
                'program'       => $messages->first('program'),
                'kode_kegiatan' => $messages->first('kode_kegiatan'),
                'kegiatan'      => $messages->first('kegiatan')
            ];

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
            // menghilangkan html caracter

            $program = strip_tags(trim(Input::get('program')));
            $kode_kegiatan = strip_tags(trim(Input::get('kode_kegiatan')));
            $kegiatan = strip_tags(trim(Input::get('kegiatan')));

            // huruf besar pada awal kata
            // $kewenangan = ucwords(strtolower($kewenangan));

            // update
            $data = Kegiatan::find($id);
            $data->id_program = $program;
            $data->kode_kegiatan = $kode_kegiatan;
            $data->kegiatan = $kegiatan;
            $data->save();

            // set response jika sukses
            $response = [
                'Status' => 'Sukses',
                'msg'    => 'Sukses : Data berhasil disimpan.',
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

        $data = Kegiatan::find($id);
        $data->delete();

        $response = array(
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        );

        return Response::json($response);
    }

}