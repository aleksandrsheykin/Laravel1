<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;

class ErrorController extends Controller
{
    public function index($errorCode)
    {
		dd(111);
		return view('errors.code', $errorCode);
    }
}
