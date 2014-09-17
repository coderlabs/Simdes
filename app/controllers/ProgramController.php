<?php

class ProgramController extends \BaseController {

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
		return View::make("kewenangan.program");
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
		$data = DB::table('tb_program')
						->join('tb_bidang','tb_bidang.id','=','tb_program.id_bidang')
						->select('tb_program.id','tb_bidang.bidang','kode_program','program')
						->where('program','LIKE','%'.$term.'%')
						->orderBy('kode_program')
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
		$rules = [
			'bidang'       => 'required|numeric',
			'kode_program' => 'required|unique:tb_program,kode_program',
			'program'      => 'required|unique:tb_program,program',
			];

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = [
				'Status'       => 'Warning',
				'bidang'       => $messages->first('bidang'),
				'kode_program' => $messages->first('kode_program'),
				'program'      => $messages->first('program')
				];

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			// menghilangkan html caracter
				
			$bidang       = strip_tags(trim(Input::get('bidang')));
			$kode_program = strip_tags(trim(Input::get('kode_program')));
			$program      = strip_tags(trim(Input::get('program')));

			// huruf besar pada awal kata
			// $kewenangan = ucwords(strtolower($kewenangan)); 

			// masukkan data jika validasi sukses
			Program::create([
				'id_bidang'    => $bidang,
				'kode_program' => $kode_program,
				'program'      => $program
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
		if(!Auth::check()){
			return Response::json([
				'Status' => 'Logout',
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		$data = Bidang::get();
		foreach ($data as $value) {
			$result[] = array(
				'id'     => $value->id,
				'bidang' => substr($value->bidang,0,70)
				);
		}
		return Response::json($result);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data = Porgram::find($id);
		if($data == null){
			return Redirect::to("program");
		} else {
			return Redirect::to("program");
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
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		return Response::json(Program::find($id));
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
			'bidang'       => 'required|numeric',
			'kode_program' => 'required',
			'program'      => 'required',
			];

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = [
				'Status'       => 'Warning',
				'bidang'       => $messages->first('bidang'),
				'kode_program' => $messages->first('kode_program'),
				'program'      => $messages->first('program')
				];

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			// menghilangkan html caracter
				
			$bidang       = strip_tags(trim(Input::get('bidang')));
			$kode_program = strip_tags(trim(Input::get('kode_program')));
			$program      = strip_tags(trim(Input::get('program')));

			// update
			$data               = Program::find($id);
			$data->id_bidang    = $bidang;
			$data->kode_program = $kode_program;
			$data->program      = $program;
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
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		// cek apakah ada relasi atau sedang dipakai
		$cek = Kegiatan::all();
		foreach ($cek as $value) {
			if($value->id_program == $id){
				$response = array(
				'Status' => 'Warning',
		           'msg' => 'Data dipakai oleh relasi Kegiatan, tidak boleh dihapus!',
		       );
		 	
		   		return Response::json($response);
			}
		}
		// jika ada maka tidak boleh dihapus
		// jika tidak dipakai maka boleh dihapus

		$data = Program::find($id);
		$data->delete();

		$response = array(
			'Status' => 'Sukses',
	           'msg' => 'Sukses : Data berhasil dihapus.',
	       );
	 	
	    return Response::json($response);
	}

}