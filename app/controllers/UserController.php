<?php

use Illuminate\support\MessageBag;

class UserController extends Controller{

	public function Index(){
		// cek apakah sudah login
		if(Auth::check()){
			return Redirect::to('dashboard');
		}
		return View::make("pages.login");
	}

	public function loginAction() {

		$errors = new MessageBag();


		if($old = Input::old("errors"))
		{
			$errors = $old;
		}

		$data = [ "errors" => $errors ];


		if(Input::server("REQUEST_METHOD") == "POST") {

			$validator = Validator::make(Input::All(),[
				"email"    => "required|email",
				"password" => "required"
			]);

			if($validator->passes()){
				$credentials = [
					"email"    => Input::get("email"),
					"password" => Input::get("password")
				];

				if(Auth::attempt($credentials)) {

//                    @todo:mencoba cache dan session untuk user dan organisasi

//                    Cache::put('user', Auth::user()->name, 5);
//                    Cache::put('organisasi', Auth::user()->organisasi->nama, 5);
//                    Cache::put('user_slug', Auth::user()->slug, 5);

					return Redirect::to("dashboard");

				}
			}

			$data["errors"] = new MessageBag([
			 	"password" => [ "Email and/or password invalid." ]
			]);

			$data["email"] = Input::get("email");

			return Redirect::route("user/login")->withInput($data);

		}

		return View::make("pages.login",$data);
	}

	public function logoutAction() {

		Auth::logout();
		return Redirect::route("user/login");
	}

}