<?php

class KewenanganController extends \BaseController {

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
		return View::make("kewenangan.kewenangan");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param string $term
	 * @return Response Json
	 */
	public function read()
	{
		// cek apakah sudah login pemanggilan data via Ajax
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali!'
			]);
		}

		$term = Input::get('term');		
		$data = Kewenangan::orderBy('kode_kewenangan')->where('kewenangan','LIKE','%'.$term.'%')->paginate(10);
						
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
		$rules = [
			'kode_kewenangan' => 'required|min:1|unique:tb_kewenangan,kode_kewenangan',
			'kewenangan'      => 'required|min:5|unique:tb_kewenangan,kewenangan'
			];

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = [
				'Status'          => 'Warning',
				'kode_kewenangan' => $messages->first('kode_kewenangan'),
				'kewenangan'      => $messages->first('kewenangan')
				];

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			// menghilangkan html caracter
			$kode_kewenangan = strip_tags(trim(Input::get('kode_kewenangan')));
			$kewenangan      = strip_tags(trim(Input::get('kewenangan')));

			// huruf besar pada awal kata
			// $kewenangan = ucwords(strtolower($kewenangan)); 

			// masukkan data jika validasi sukses
			Kewenangan::create([
				'kode_kewenangan' => $kode_kewenangan,
				'kewenangan'      => $kewenangan
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data = Kewenangan::find($id);
		if($data == null){
			return Redirect::to("kewenangan");
		} else {
			return Redirect::to("kewenangan");
		}
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
				'msg' => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		return Response::json(Kewenangan::find($id));
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
		$rules = [
			'kode_kewenangan' => 'required',
			'kewenangan'      => 'required'
			];

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = [
				'Status'          => 'Warning',
				'kode_kewenangan' => $messages->first('kode_kewenangan'),
				'kewenangan'      => $messages->first('kewenangan')
				];

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			// menghilangkan html caracter
			$kode_kewenangan = strip_tags(trim(Input::get('kode_kewenangan')));
			$kewenangan      = strip_tags(trim(Input::get('kewenangan')));

			// huruf besar pada awal kata
			// $kewenangan = ucwords(strtolower($kewenangan)); 

			// update
			$data                  = Kewenangan::find($id);
			$data->kode_kewenangan = $kode_kewenangan;
			$data->kewenangan      = $kewenangan;
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

		// cek apakah ada relasi atau sedang dipakai
		$cek = Bidang::all();
		foreach ($cek as $value) {
			if($value->id_kewenangan == $id){
				$response = array(
				'Status' => 'Warning',
		           'msg' => 'Data dipakai oleh relasi Bidang, tidak boleh dihapus!',
		       );
		 	
		   		return Response::json($response);
			}
		}
		
		// jika ada maka tidak boleh dihapus
		// jika tidak dipakai maka boleh dihapus

		$data = Kewenangan::find($id);
		$data->delete();

		$response = array(
			'Status' => 'Sukses',
	           'msg' => 'Sukses : Data berhasil dihapus.',
	       );
	 	
	    return Response::json($response);
	}

}