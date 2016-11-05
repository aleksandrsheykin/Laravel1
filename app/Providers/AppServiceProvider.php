<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function($view) {
            $url = 'http://oauth.vk.com/authorize';	//делаем ссылку для авторизации через vk
            $params = array(
                'client_id'     => Config('constants.VK_CLIENT_ID'),
                'redirect_uri'  => Config('constants.VK_CLIENT_URI'),
                'response_type' => 'code'
            );
            
            $vk_link_href = $url . '?' . urldecode(http_build_query($params));
			$view->with('vk_link', $vk_link_href);
			
			if (Gate::allows('isAdmin')) {	//если админ, то в шапке добавляем ссылку на панель администратора
				$view->with('admin_link', Route('admin'));
			}
			
			//$view->with('current_date', );
        });
		
		view()->composer('layouts.leftmenu', function($view) {
			$view->with('category_count', Auth::User()->getCategories()->count());
			$view->with('cash_count', Auth::User()->getCash()->count());
		});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
