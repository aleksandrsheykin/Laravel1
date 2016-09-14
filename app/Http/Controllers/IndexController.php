<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Routing\Controller;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 	
		if (!Auth::check()) {
			if ($request->input('code')) {	//авторизация через vk
				$code = preg_replace('![^\w\d]*!', '', $request->input('code'));    //оставляем только буквы и цифры
				
				$params = array(
					'client_id'     => Config('constants.VK_CLIENT_ID'),
					'client_secret' => Config('constants.VK_CLIENT_SECRET'),
					'code' => $code,
					'redirect_uri'  => Config('constants.VK_CLIENT_URI')
				);
				
				$token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
				
				if (isset($token['access_token'])) {
					$params = array(
						'uids'         => $token['user_id'],
						'fields'       => 'uid,first_name,last_name,screen_name',
						'access_token' => $token['access_token']
					);
					
					$userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
					
					if (isset($userInfo['response'][0]['uid'])) {
						$userInfo = $userInfo['response'][0];
						$result = true;
					}                
				}
				
				if ($result) {
					$vk_id = $userInfo['uid'];
					$vk_mail = $userInfo['uid'].'@vk.com';
					//$vk_pas = $userInfo['uid'];
					$vk_pas = str_random(20);
					$user = User::where('vk_id', '=', $vk_id)->first();
					if (!$user) {	//Юзера не существует
						$user = User::create([			//создаем юзера vk
							'firstname' => $userInfo['first_name'],
							'lastname' => $userInfo['last_name'],
							'email' => $vk_mail,
							'password' => bcrypt($vk_pas),
							'vk_id' => $vk_id,
						]);
					} 

					if (Auth::loginUsingId($user->id)) {	//авторизовываем vk юзера
						return redirect()->intended('home');
					}
				}
			}
		}
        return view('index');
    }
}
