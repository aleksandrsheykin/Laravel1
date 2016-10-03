<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheaperController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$data = [
				'selected_menu' => 'cheaper',
				];		
        return view('cheaper', $data);
    }
}
