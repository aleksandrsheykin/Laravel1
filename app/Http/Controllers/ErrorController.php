<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		$data = [
				'selected_menu' => 'question',
				];		
        return view('question', $data);
    }
}
