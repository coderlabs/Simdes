<?php

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * The layout used by the controller.
     *
     * @var \Illuminate\View\View
     */
    protected $layout = 'layouts.default';

    /**
     * Auth untuk cek validasi organisasi_id dan user_id
     *
     * @var
     */
    protected $auth;

    /**
     * @var
     */
    protected $input;

    /**
     * Create a new BaseController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => ['post']]);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * Set the specified view as content on the layout.
     *
     * @param  string $path
     * @param  array $data
     * @return void
     */
    protected function view($path, $data = [])
    {
        $this->layout->content = View::make($path, $data);
    }

    /**
     * Input Get
     *
     * @param $input
     * @return mixed
     */
    protected function input($input)
    {
        return Input::get($input);
    }

    /**
     * Redirect to the specified named route.
     *
     * @param  string $route
     * @param  array $params
     * @param  array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectRoute($route, $params = [], $data = [])
    {
        return Redirect::route($route, $params)->with($data);
    }

    /**
     * @param $url
     * @return mixed
     */
    protected function redirectURLTo($url)
    {
        return Redirect::to($url);
    }

    /**
     * Redirect back with old input and the specified data.
     *
     * @param  array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBack($data = [])
    {
        return \Redirect::back()->withInput()->with($data);
    }

    /**
     * Redirect a logged in user to the previously intended url.
     *
     * @param  mixed $default
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectIntended($default = null)
    {
        return Redirect::intended($default);
    }

    /**
     * method untuk konversi tanggal MySql
     * menjadi tanggal indonesia output
     * dari tanggal  : 2 Agustus 2014
     *
     * @param $date
     *
     * @return string
     */
    public function dateIndonesia($date)
    {
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);

        $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;

        return ($result);
    }
}
