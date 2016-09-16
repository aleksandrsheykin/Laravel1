<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUsersController extends Controller
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
        $users = User::paginate(20);
        //dd($users);
		$data = ['user_count' => User::all()->count(),
				'selected_menu' => 'Users',
                'users' => $users
				];
		return view('admin.users', $data);
    }
}
