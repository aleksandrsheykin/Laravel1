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
        
		$data = [
                'selected_menu' => 'Categories'
				];
		return view('admin.categories', $data);
    }
	
    public function put(Request $request)
    {
		if ($request->input('addCategory')) {	
			dd($request->input());
		} else {
			dd(222);
		}
        
		$data = [
                'selected_menu' => 'Categories'
				];
		return view('admin.categories', $data);
    }	
	
}
