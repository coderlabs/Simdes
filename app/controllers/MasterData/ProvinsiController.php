<?php
namespace MasterData;

class ProvinsiController extends \BaseController
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
        return View::make("master.provinsi");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @internal param string $term
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

        $data = Provinsi::where('prov', 'LIKE', '%' . $term . '%')->orderBy('kode_prov')->paginate(10);
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
            'kode_provinsi' => 'required|numeric|unique:tb_master_prov,kode_prov',
            'provinsi'      => 'required|unique:tb_master_prov,prov',
            'seo'           => 'required|unique:tb_master_prov,seo'
        );

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi Warning
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = array(
                'Status'        => 'Warning',
                'kode_provinsi' => $messages->first('kode_provinsi'),
                'provinsi'      => $messages->first('provinsi'),
                'seo'           => $messages->first('seo'),
            );

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
            $kode_provinsi = strip_tags(trim(Input::get('kode_provinsi')));
            $provinsi = strip_tags(trim(Input::get('provinsi')));
            $seo = strip_tags(trim(Input::get('seo')));
            $provinsi = ucwords(strtolower($provinsi));
            $seo = strtolower($seo);

            // masukkan data jika validasi sukses
//			Provinsi::create(array(
//				'kode_prov' => $kode_provinsi,
//				'prov'      => $provinsi,
//				'seo'       => $seo,
//				));
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
        return View::make("master.provinsi");
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

        $data = Provinsi::find($id);
        $result = [
            'id'            => $data->id,
            'kode_provinsi' => $data->kode_prov,
            'provinsi'      => $data->prov,
            'seo'           => $data->seo,
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
            'kode_provinsi' => 'required|numeric',
            'provinsi'      => 'required',
            'seo'           => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        // kirim data jika validasi Warning
        if ($validator->fails()) {
            $messages = $validator->messages();
            $response = array(
                'Status'        => 'Warning',
                'kode_provinsi' => $messages->first('kode_provinsi'),
                'provinsi'      => $messages->first('provinsi'),
                'seo'           => $messages->first('seo'),
            );

            return Response::json($response);

        } else {

            // sanitasi data
            // menghapus sepasi diantara karakter
//			$kode_provinsi   = strip_tags(trim(Input::get('kode_provinsi')));
//			$provinsi        = strip_tags(trim(Input::get('provinsi')));
//			$seo             = strip_tags(trim(Input::get('seo')));
//			$provinsi        = ucwords(strtolower($provinsi));
//			$seo             = strtolower($seo);
//
//			// update
//			$data            = Provinsi::find($id);
//			$data->kode_prov = $kode_provinsi;
//			$data->prov      = $provinsi;
//			$data->seo       = $seo;
//			$data->save();
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
//	           'msg' => 'Master data Provinsi tidak boleh dihapus.',
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