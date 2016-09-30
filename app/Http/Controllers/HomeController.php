<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	protected $date_mainform; 
	 
    public function __construct(Request $request)
    {
        $this->middleware('auth');
		
		$d = array_get(Route::current()->parameters(), 'date_mainform');	//если дата есть в запросе, то берем, иначе ставим текущую
		if ($d == null) {
			//$this->setDateMainform(date("d/m/Y"));
			$this->setDateMainform(date());
		} else {
			$this->setDateMainform($d);
		}		
    }

	public function setDateMainform($d) //привести к нужному для выборки виду
	{	
		$d = str_replace('/', '', $d);
		$this->date_mainform = $d;
	}
	
	public function getDateMainform() 
	{	
		//dd($this->date_mainform);
		return $this->date_mainform;
	}	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$data = [
                'date_mainform' => $this->getDateMainform()
				];		
        return view('home', $data);
    }
}
