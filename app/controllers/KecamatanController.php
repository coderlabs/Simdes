<?php

class KecamatanController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// cek apakah sudah login
		if(!Auth::check()){
			return Redirect::to('login');
		}
		return View::make("master.kecamatan");
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
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		$term = Input::get('term');
		$data = DB::table('tb_master_kec')
						->join('tb_master_kab','tb_master_kab.kode_kab','=','tb_master_kec.kode_kab')
						->join('tb_master_prov','tb_master_prov.kode_prov','=','tb_master_kab.kode_prov')
						->select('tb_master_kec.id','tb_master_prov.prov','tb_master_kab.status','tb_master_kab.kab','kode_kec','kec')
						->where('kec','LIKE','%'.$term.'%')
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
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}
		// cek apakah dikirim via form ajax
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ) );
        }

		// cek validasi
		$rules = array(
			'kode_kabupaten' => 'required',
			'kode_kecamatan' => 'required|unique:tb_master_kec,kode_kec',
			'kecamatan'      => 'required|unique:tb_master_kec,kec',
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi Warning
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'         => 'Warning',
				'kode_kabupaten'  => $messages->first('kode_kabupaten'),
				'kode_kecamatan' => $messages->first('kode_kecamatan'),
				'kecamatan'      => $messages->first('kecamatan'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kode_kabupaten = strip_tags(trim(Input::get('kode_kabupaten')));
			$kode_kecamatan = strip_tags(trim(Input::get('kode_kecamatan')));
			$kecamatan      = strip_tags(trim(Input::get('kecamatan')));
			$kecamatan      = ucwords(strtolower($kecamatan)); 
			

			// masukkan data jika validasi sukses
			Kecamatan::create(array(
				'kode_kab' => $kode_kabupaten,
				'kode_kec' => $kode_kecamatan,
				'kec'      => $kecamatan,
			));

			// set response jika sukses
			$response = array(
				'Status' => 'Sukses',
				'msg'    => 'Sukses : Data berhasil disimpan.',
	        );
	 
	        return Response::json($response);	
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make("master.kecamatan");
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// cek apakah sudah login
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		$data     = Kecamatan::find($id);
		$data_kab = Kabupaten::where('kode_kab','=',$data->kode_kab)->get();

		$result = [];
		foreach ($data_kab as $value) {
			$data_prov = Provinsi::where('kode_prov','=',$value->kode_prov)->get();
			foreach ($data_prov as $dt) {
				$result = [
					'id'             => $data->id,
					'kode_provinsi'  => $dt->kode_prov,
					'kode_kabupaten' => $value->kode_kab,
					'kode_kecamatan' => $data->kode_kec,
					'kecamatan'            => $data->kec,
				];
			}
		}

		return Response::json($result);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// cek apakah sudah login
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}
		// cek apakah dikirim via form ajax
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'msg' => 'Anda tidak memiliki otentikasi untuk input data!'
            ) );
        }

		// cek validasi
		$rules = array(
			'kode_kabupaten' => 'required',
			'kode_kecamatan' => 'required',
			'kecamatan'      => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi Warning
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'         => 'Warning',
				'kode_kabupaten' => $messages->first('kode_kabupaten'),
				'kode_kecamatan' => $messages->first('kode_kecamatan'),
				'kecamatan'      => $messages->first('kecamatan'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kode_kabupaten = strip_tags(trim(Input::get('kode_kabupaten')));
			$kode_kecamatan = strip_tags(trim(Input::get('kode_kecamatan')));
			$kecamatan      = strip_tags(trim(Input::get('kecamatan')));
			$kecamatan      = ucwords(strtolower($kecamatan)); 
			

			// masukkan data jika validasi sukses
			$data           = Kecamatan::find($id);
			$data->kode_kab = $kode_kabupaten;
			$data->kode_kec = $kode_kecamatan;
			$data->kec      = $kecamatan;
			$data->save();

			// set response jika sukses
			$response = array(
				'Status' => 'Sukses',
				'msg'    => 'Sukses : Data berhasil diupdate.',
	        );
	 
	        return Response::json($response);	
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// cek apakah sudah login
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg' => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		$response = array(
			'Status' => 'Warning',
	           'msg' => 'Master data Kecamatan tidak boleh dihapus.',
	       );
	 	
	    return Response::json($response);	
	}

}