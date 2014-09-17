<?php

class BidangController extends \BaseController {

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
		return View::make("kewenangan.bidang");
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
		$data = DB::table('tb_bidang')
						->join('tb_kewenangan','tb_kewenangan.id','=','tb_bidang.id_kewenangan')
						->select('tb_bidang.id','tb_kewenangan.kewenangan','kode_bidang','bidang','regulasi')
						->where('bidang','LIKE','%'.$term.'%')
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
			'kewenangan'   => 'required|numeric',
			'kode_bidang'  => 'required|unique:tb_bidang,kode_bidang',
			'bidang'       => 'required|unique:tb_bidang,bidang',
			'regulasi'     => 'required|max:255',
			'tanggal'      => 'required|date',
			'pengundangan' => 'required|max:255'
			];

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = [
				'Status'       => 'Warning',
				'kewenangan'   => $messages->first('kewenangan'),
				'kode_bidang'  => $messages->first('kode_bidang'),
				'bidang'       => $messages->first('bidang'),
				'regulasi'     => $messages->first('regulasi'),
				'tanggal'      => $messages->first('tanggal'),
				'pengundangan' => $messages->first('pengundangan')
				];

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			// menghilangkan html caracter
			$kewenangan   = strip_tags(trim(Input::get('kewenangan')));
			$kode_bidang  = strip_tags(trim(Input::get('kode_bidang')));
			$bidang       = strip_tags(trim(Input::get('bidang')));
			$regulasi     = strip_tags(trim(Input::get('regulasi')));
			$tanggal      = strip_tags(trim(Input::get('tanggal')));
			$pengundangan = strip_tags(trim(Input::get('pengundangan')));

			// huruf besar pada awal kata
			// $kewenangan = ucwords(strtolower($kewenangan)); 

			// masukkan data jika validasi sukses
			Bidang::create([
				'id_kewenangan' => $kewenangan,
				'kode_bidang'   => $kode_bidang,
				'bidang'        => $bidang,
				'regulasi'      => $regulasi,
				'tanggal'       => $tanggal,
				'pengundangan'  => $pengundangan
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

		$data = Kewenangan::get();
		foreach ($data as $value) {
			$result[] = array(
				'id'         => $value->id,
				'kewenangan' => substr($value->kewenangan,0,70)
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
		$data = Bidang::find($id);
		if($data == null){
			return Redirect::to("bidang");
		} else {
			return Redirect::to("bidang");
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

		return Response::json(Bidang::find($id));
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
                'msg' => 'Anda tidak memiliki otentikasi untuk update data!'
            ) );
        }

		// cek validasi
		$rules = [
			'kewenangan'   => 'required',
			'kode_bidang'  => 'required',
			'bidang'       => 'required',
			'regulasi'     => 'required',
			'tanggal'      => 'required|date',
			'pengundangan' => 'required'
			];

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = [
				'Status'       => 'Warning',
				'kewenangan'   => $messages->first('kewenangan'),
				'kode_bidang'  => $messages->first('kode_bidang'),
				'bidang'       => $messages->first('bidang'),
				'regulasi'     => $messages->first('regulasi'),
				'tanggal'      => $messages->first('tanggal'),
				'pengundangan' => $messages->first('pengundangan')
				];

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			// menghilangkan html caracter
			$kewenangan   = strip_tags(trim(Input::get('kewenangan')));
			$kode_bidang  = strip_tags(trim(Input::get('kode_bidang')));
			$bidang       = strip_tags(trim(Input::get('bidang')));
			$regulasi     = strip_tags(trim(Input::get('regulasi')));
			$tanggal      = strip_tags(trim(Input::get('tanggal')));
			$pengundangan = strip_tags(trim(Input::get('pengundangan')));

			// update
			$data                = Bidang::find($id);
			$data->id_kewenangan = $kewenangan;
			$data->kode_bidang   = $kode_bidang;
			$data->bidang        = $bidang;
			$data->regulasi      = $regulasi;
			$data->tanggal       = $tanggal;
			$data->pengundangan  = $pengundangan;
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
		$cek = Program::all();
		foreach ($cek as $value) {
			if($value->id_bidang == $id){
				$response = array(
				'Status' => 'Warning',
		           'msg' => 'Data dipakai oleh relasi Program, tidak boleh dihapus!',
		       );
		 	
		   		return Response::json($response);
			}
		}
		// jika ada maka tidak boleh dihapus
		// jika tidak dipakai maka boleh dihapus

		$data = Bidang::find($id);
		$data->delete();

		$response = array(
			'Status' => 'Sukses',
	           'msg' => 'Sukses : Data berhasil dihapus.',
	       );
	 	
	    return Response::json($response);
	}

}