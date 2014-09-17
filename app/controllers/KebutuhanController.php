<?php

class KebutuhanController extends \BaseController {

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
		return View::make("prioritas.kebutuhan");
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

		$data = DB::table('tb_kebutuhan')
						->join('tb_kegiatan','tb_kegiatan.id','=','tb_kebutuhan.kd_kegiatan')
						->select('tb_kebutuhan.id','tb_kegiatan.kegiatan','kebutuhan','kode_kebutuhan')
						->orderBy('id')
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
			'kegiatan'       => 'required|numeric',
			'kode_kebutuhan' => 'required|min:5|unique:tb_kebutuhan,kode_kebutuhan',
			'kebutuhan'      => 'required|min:2|unique:tb_kebutuhan,kebutuhan'
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'        => 'Warning',
				'kegiatan'       => $messages->first('kegiatan'),
				'kode_kebutuhan' => $messages->first('kode_kebutuhan'),
				'kebutuhan'      => $messages->first('kebutuhan'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kegiatan       = trim(Input::get('kegiatan'));
			$kode_kebutuhan = trim(Input::get('kode_kebutuhan'));
			$kebutuhan      = trim(Input::get('kebutuhan'));

			// huruf besar pada awal kata
			$kebutuhan = ucwords(strtolower($kebutuhan)); 

			// masukkan data jika validasi sukses
			Kebutuhan::create(array(
				'kd_kegiatan'    => $kegiatan,
				'kode_kebutuhan' => $kode_kebutuhan,
				'kebutuhan'      => $kebutuhan
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
	public function ajax()
	{
		// cek apakah sudah login
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg' => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		$data = Kegiatan::select(['id','kegiatan'])->get();
		return Response::json($data);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Redirect::to("kegiatan-kebutuhan");
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

		return Response::json(Kebutuhan::find($id));
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
			'kegiatan'       => 'required|numeric',
			'kode_kebutuhan' => 'required|min:5',
			'kebutuhan'      => 'required|min:2'
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'        => 'Warning',
				'kegiatan'       => $messages->first('kegiatan'),
				'kode_kebutuhan' => $messages->first('kode_kebutuhan'),
				'kebutuhan'      => $messages->first('kebutuhan'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kegiatan       = trim(Input::get('kegiatan'));
			$kode_kebutuhan = trim(Input::get('kode_kebutuhan'));
			$kebutuhan      = trim(Input::get('kebutuhan'));

			// huruf besar pada awal kata
			$kebutuhan = ucwords(strtolower($kebutuhan)); 

			// update
			$data                 = Kebutuhan::find($id);
			$data->kd_kegiatan       = $kegiatan;
			$data->kode_kebutuhan = $kode_kebutuhan;
			$data->kebutuhan      = $kebutuhan;
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

		$data = Kebutuhan::find($id);
		$data->delete();

		$response = array(
			'Status' => 'Sukses',
	           'msg' => 'Sukses : Data berhasil dihapus.',
	       );
	 	
	    return Response::json($response);
	}

}