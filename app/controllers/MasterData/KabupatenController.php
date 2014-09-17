<?php
namespace MasterData;

class KabupatenController extends \BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

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
        return View::make("master.kabupaten");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $term
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

        $term = Input::get('term');
        $data = DB::table('tb_master_kab')
            ->join('tb_master_prov', 'tb_master_prov.kode_prov', '=', 'tb_master_kab.kode_prov')
            ->select('tb_master_kab.id', 'tb_master_prov.prov', 'kode_kab', 'kab', 'status', 'tb_master_kab.seo', 'zona_waktu')
            ->where('kab', 'LIKE', '%' . $term . '%')
            ->orderBy('tb_master_prov.kode_prov')
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
        $rules = array(
            'kode_provinsi'  => 'required',
            'kode_kabupaten' => 'required|unique:tb_master_kab,kode_kab',
            'kabupaten'      => 'required|unique:tb_master_kab,kab',
            'status'         => 'required',
            'zona_waktu'     => 'required',
            'seo'            => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi Warning
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = array(
                'Status'         => 'Warning',
                'kode_provinsi'  => $messages->first('kode_provinsi'),
                'kode_kabupaten' => $messages->first('kode_kabupaten'),
                'kabupaten'      => $messages->first('kabupaten'),
                'status'         => $messages->first('status'),
                'zona_waktu'     => $messages->first('zona_waktu'),
                'seo'            => $messages->first('seo'),
            );

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
            $kode_provinsi = strip_tags(trim(Input::get('kode_provinsi')));
            $kode_kabupaten = strip_tags(trim(Input::get('kode_kabupaten')));
            $kabupaten = strip_tags(trim(Input::get('kabupaten')));
            $status = strip_tags(trim(Input::get('status')));
            $zona_waktu = strip_tags(trim(Input::get('zona_waktu')));
            $seo = strip_tags(trim(Input::get('seo')));

            $kabupaten = ucwords(strtolower($kabupaten));
            $seo = strtolower($seo);
            $zona_waktu = strtoupper($zona_waktu);

            // masukkan data jika validasi sukses
//			Kabupaten::create(array(
//				'kode_prov'  => $kode_provinsi,
//				'kode_kab'   => $kode_kabupaten,
//				'kab'        => $kabupaten,
//				'status'     => $status,
//				'zona_waktu' => $zona_waktu,
//				'seo'        => $seo,
//			));
//
//			// set response jika sukses
//			$response = array(
//				'Status' => 'Sukses',
//				'msg'    => 'Sukses : Data berhasil disimpan.',
//	        );
//
//	        return Response::json($response);

            // dalam masa percobaan akan dinonaktifkan
            // fitur create, update dan delete
            // todo : aktifkan kembali
            // kembalikan return bahwa ini adalah demo
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf anda tidak diperkenankan untuk melakukan aksi ini'
            ];
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
        return View::make("master.kabupaten");
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

        $data = Kabupaten::find($id);
        $result = [
            'id'             => $data->id,
            'kode_provinsi'  => $data->kode_prov,
            'kode_kabupaten' => $data->kode_kab,
            'kabupaten'      => $data->kab,
            'status'         => $data->status,
            'seo'            => $data->seo,
            'zona_waktu'     => $data->zona_waktu,
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
            return Response::json(array(
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ));
        }

        // cek validasi
        $rules = array(
            'kode_provinsi'  => 'required',
            'kode_kabupaten' => 'required',
            'kabupaten'      => 'required',
            'status'         => 'required',
            'zona_waktu'     => 'required',
            'seo'            => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi Warning
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = array(
                'Status'         => 'Warning',
                'kode_provinsi'  => $messages->first('kode_provinsi'),
                'kode_kabupaten' => $messages->first('kode_kabupaten'),
                'kabupaten'      => $messages->first('kabupaten'),
                'status'         => $messages->first('status'),
                'zona_waktu'     => $messages->first('zona_waktu'),
                'seo'            => $messages->first('seo'),
            );

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
//			$kode_provinsi    = strip_tags(trim(Input::get('kode_provinsi')));
//			$kode_kabupaten   = strip_tags(trim(Input::get('kode_kabupaten')));
//			$kabupaten        = strip_tags(trim(Input::get('kabupaten')));
//			$status           = strip_tags(trim(Input::get('status')));
//			$zona_waktu       = strip_tags(trim(Input::get('zona_waktu')));
//			$seo              = strip_tags(trim(Input::get('seo')));
//
//			$kabupaten        = ucwords(strtolower($kabupaten));
//			$seo              = strtolower($seo);
//			$zona_waktu       = strtoupper($zona_waktu);
//
//			// update
//			$data             = Kabupaten::find($id);
//
//			$data->kode_prov  = $kode_provinsi;
//			$data->kode_kab   = $kode_kabupaten;
//			$data->kab        = $kabupaten;
//			$data->status     = $status;
//			$data->zona_waktu = $zona_waktu;
//			$data->seo        = $seo;
//			$data->save();
//
//			// set response jika sukses
//			$response = array(
//				'Status' => 'Sukses',
//				'msg'    => 'Sukses : Data berhasil diupdate.',
//	        );
//
//	        return Response::json($response);
            // dalam masa percobaan akan dinonaktifkan
            // fitur create, update dan delete
            // todo : aktifkan kembali
            // kembalikan return bahwa ini adalah demo
            return [
                'Status' => 'Warning',
                'msg'    => 'Mohon maaf anda tidak diperkenankan untuk melakukan aksi ini'
            ];
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

//		$response = array(
//			'Status' => 'Warning',
//	           'msg' => 'Master data Kabupaten tidak boleh dihapus.',
//	       );
//
//	    return Response::json($response);

        // dalam masa percobaan akan dinonaktifkan
        // fitur create, update dan delete
        // todo : aktifkan kembali
        // kembalikan return bahwa ini adalah demo
        return [
            'Status' => 'Warning',
            'msg'    => 'Mohon maaf anda tidak diperkenankan untuk melakukan aksi ini'
        ];
    }

}