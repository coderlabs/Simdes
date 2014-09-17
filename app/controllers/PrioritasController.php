<?php

class PrioritasController extends \BaseController {

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
		return View::make("prioritas.prioritas");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function read()
	{
		// cek apakah sudah login
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg' => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		return Response::json(Prioritas::paginate(10));
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
				'msg' => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
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
			'kode_prioritas' => 'required|min:2|unique:tb_prioritas,kode_prioritas',
			'prioritas'      => 'required|min:4'
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'         => 'Warning',
				'kode_prioritas' => $messages->first('kode_prioritas'),
				'prioritas'      => $messages->first('prioritas'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kode_prioritas = trim(Input::get('kode_prioritas'));
			$prioritas      = trim(Input::get('prioritas'));
			// 
			$prioritas = ucwords(strtolower($prioritas)); 

			// masukkan data jika validasi sukses
			Prioritas::create(array(
				'kode_prioritas' => $kode_prioritas,
				'prioritas'      => $prioritas
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
		return Redirect::to("prioritas-program-pembangunan");
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

		return Response::json(Prioritas::find($id));
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
				'msg' => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
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
			'kode_prioritas' => 'required|min:2',
			'prioritas'      => 'required|min:4'
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'         => 'Warning',
				'kode_prioritas' => $messages->first('kode_prioritas'),
				'prioritas'      => $messages->first('prioritas'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kode_prioritas = trim(Input::get('kode_prioritas'));
			$prioritas      = trim(Input::get('prioritas'));
			// 
			$prioritas = ucwords(strtolower($prioritas)); 

			// update
			$data                 = Prioritas::find($id);
			$data->kode_prioritas = $kode_prioritas;
			$data->prioritas      = $prioritas;
			$data->save();

			// set response jika sukses
			$response = array(
				'Status' => 'Sukses',
				'msg'    => 'Sukses : Data berhasil disimpan.',
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

		$data = Prioritas::find($id);
		$data->delete();

		$response = array(
			'Status' => 'Sukses',
	           'msg' => 'Sukses : Data berhasil dihapus.',
	       );
	 	
	    return Response::json($response);	
	}

}