<?php

class UserManagemenController extends \BaseController {

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
		return View::make("user.user-log");
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
				'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
			]);
		}

		// cek apakah dikirim via form ajax
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json([
				'Status' => 'Warning',
				'Action' => 'Logout',
				'msg'    => 'Data dikirim tidak sesuai dengan prosedur program. Indikasi XSS, silahkan login kembali!',
            ]);
        }

		$term  = Input::get('param');
		$data = DB::table('tb_user_log')
						->select('nama','jenis','deskripsi','created_at')
						->where('deskripsi','LIKE','%'.$term.'%')
						->orderBy('id','desc')
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
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// cek apakah sudah login
		if(!Auth::check()){
			return Redirect::to('login');
		}
		$data = User::find($id);

		if($data == null){
			return Redirect::to("user-log");
		} else {
			return View::make("user.user-profile")->with(['data'=> $data]);
		}
	}

    public function findBySlug($slug)
    {
        // cek apakah sudah login
        if(!Auth::check()){
            return Redirect::to('login');
        }
        $data = User::whereSlug($slug)->first();

        if($data == null){
            return Redirect::to("user-log");
        } else {
            return View::make("user.user-profile")->with(['data'=> $data]);
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
		//
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
            return Response::json([
				'Status' => 'Warning',
				'Action' => 'Logout',
				'msg'    => 'Data dikirim tidak sesuai dengan prosedur program. Indikasi XSS, silahkan login kembali!',
            ]);
        }

		// cek validasi
		$rules = array(
			'name'  => 'required',
			'email' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		// kirim data jika validasi gagal
		if($validator->fails()){
			$messages = $validator->messages();
			$response = [
				'Status'        => 'Validation',
				'validation' => [
						'name'      => $messages->first('name'),
						'email'     => $messages->first('email'),
					],
				];

			return Response::json($response);

		} else {
			
			// sanitasi data
			// menghapus sepasi diantara karakter
			$name  = strip_tags(trim(Input::get('name')));
			$email = strip_tags(trim(Input::get('email')));
						
			// huruf besar pada awal kata
			$name = ucwords(strtolower($name)); 

			// masukkan data jika validasi sukses
			try {
				$data        = User::find($id);
				$data->name  = $name;
				$data->email = $email;
				$data->save();
			} catch (Exception $e) {
				$response = [
					'Status'      => 'Warning',
					'msg'         => 'Gagal menyimpan ke database. Pesan : '.$e->getMessage(),
		        ];
		        goto response;
			}

			// simpan di userlog
			try {

				$log = new UserLog();
				$log->user_id = Auth::user()->id;
				$log->nama = Auth::user()->name;
				$log->created_at = new DateTime;
				$log->jenis = 'Update';
				$log->deskripsi = "Update user : ".$data->name;
				$log->save();

			} catch (Exception $e) {
				$response = [
					'Status'      => 'Warning',
					'msg'         => 'Gagal menyimpan ke database. Pesan : '.$e->getMessage(),
		        ];
		        goto response;
			}


			// set response jika sukses
			$response = [
				'Status' => 'Sukses',
				'msg'    => 'Sukses : Data berhasil diupdate.',
	        ];
response:
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
		//
	}


}
