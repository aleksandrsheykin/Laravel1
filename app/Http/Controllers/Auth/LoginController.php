<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
	
    /*public function index()
    { 
		$url = 'http://oauth.vk.com/authorize';
		$params = array(
			'client_id'     => Config('constants.VK_CLIENT_ID'),
			'redirect_uri'  => Config('constants.VK_CLIENT_URI'),
			'response_type' => 'code'
		);
		
		$vk_link_href = $url . '?' . urldecode(http_build_query($params));
		$templ_data = ['vk_link_href' => $vk_link_href];
        return view('auth.login', $templ_data);
    }	*/
}
