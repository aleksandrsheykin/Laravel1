<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		/*if (!Gate::allows('isAdmin')) {
			return view('errors.404');
		}*/
    }

    public function index()
    {
		$data = ['user_count' => User::all()->count(),
				'selected_menu' => 'overview'
				];
		return view('admin.content', $data);
    }
}
