<?php

class DesaController extends \BaseController {

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
		return View::make("master.desa");
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
		$data = DB::table('tb_master_desa')
						->join('tb_master_kec','tb_master_kec.kode_kec','=','tb_master_desa.kode_kec')
						->join('tb_master_kab','tb_master_kab.kode_kab','=','tb_master_kec.kode_kab')
						->join('tb_master_prov','tb_master_prov.kode_prov','=','tb_master_kab.kode_prov')
						->select('tb_master_desa.id','tb_master_prov.prov','tb_master_kab.status','tb_master_kec.kec','tb_master_kab.kab','kode_desa','desa')
						->where('desa','LIKE','%'.$term.'%')
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
			'kode_kecamatan' => 'required',
			'kode_desa'      => 'required|unique:tb_master_desa,kode_desa',
			'desa'           => 'required|unique:tb_master_desa,desa',
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi Warning
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'         => 'Warning',
				'kode_kecamatan' => $messages->first('kode_kecamatan'),
				'kode_desa'      => $messages->first('kode_desa'),
				'desa'           => $messages->first('desa'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kode_kecamatan = strip_tags(trim(Input::get('kode_kecamatan')));
			$kode_desa      = strip_tags(trim(Input::get('kode_desa')));
			$desa           = strip_tags(trim(Input::get('desa')));
			$desa           = ucwords(strtolower($desa)); 
			

			// masukkan data jika validasi sukses
			Desa::create(array(
				'kode_kec'  => $kode_kecamatan,
				'kode_desa' => $kode_desa,
				'desa'      => $desa,
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
		return View::make("master.desa");
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

		$data     = Desa::find($id);
		$data_kec = Kecamatan::where('kode_kec','=',$data->kode_kec)->get();

		$result = [];
		foreach ($data_kec as $dtkec) {
			$data_kab = Kabupaten::where('kode_kab','=',$dtkec->kode_kab)->get();
			foreach ($data_kab as $dtkab) {
				$data_prov = Provinsi::where('kode_prov','=',$dtkab->kode_prov)->get();
				foreach ($data_prov as $dtprov) {
					$result = [
						'id'             => $data->id,
						'kode_provinsi'  => $dtprov->kode_prov,
						'kode_kabupaten' => $dtkab->kode_kab,
						'kode_kecamatan' => $dtkec->kode_kec,
						'kode_desa'      => $data->kode_desa,
						'desa'           => $data->desa,
					];
				}
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
			'kode_kecamatan' => 'required',
			'kode_desa'      => 'required',
			'desa'           => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi Warning
		if($validator->fails()){
			$messages = $validator->messages();
			$response = array(
				'Status'         => 'Warning',
				'kode_kecamatan' => $messages->first('kode_kecamatan'),
				'kode_desa'      => $messages->first('kode_desa'),
				'desa'           => $messages->first('desa'),
				);

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$kode_kecamatan  = strip_tags(trim(Input::get('kode_kecamatan')));
			$kode_desa       = strip_tags(trim(Input::get('kode_desa')));
			$desa            = strip_tags(trim(Input::get('desa')));
			$desa            = ucwords(strtolower($desa)); 
			
			
			// update
			$data            = Desa::find($id);
			$data->kode_kec  = $kode_kecamatan;
			$data->kode_desa = $kode_desa;
			$data->desa      = $desa;
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

		$response = array(
			'Status' => 'Warning',
	           'msg' => 'Master data Desa tidak boleh dihapus.',
	       );
	 	
	    return Response::json($response);	
	}

}