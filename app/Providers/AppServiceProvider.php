<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Gate;

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
			
			if (Gate::allows('isAdmin')) {
				$view->with('admin_link', Route('admin'));
			}			
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
