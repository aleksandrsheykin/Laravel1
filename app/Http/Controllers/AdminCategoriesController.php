<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\User;

class AdminCategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index()
    {
		$data = ['user_count' => User::all()->count(),
				'selected_menu' => 'categories'
				];
		return view('admin.content', $data);
    }
}
