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
			$this->setDateMainform(date("d/m/Y"));
			//$this->setDateMainform(date());
		} else {
			$this->setDateMainform($d);
		}		
    }

	public function setDateMainform($d) //привести к нужному для выборки виду
	{	
		$d = str_replace('/', '-', $d);
		$this->date_mainform = date('Y-m-d', strtotime($d));
	}
	
	public function getDateMainform() 
	{	
		//dd($this->date_mainform);
		return $this->date_mainform;	//Y-m-d
	}	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$data = [
                'date_mainform' => $this->getDateMainform(),
				'date_list_for_uri' => $this->generateDateList($this->getDateMainform())
				];		
        return view('home', $data);
    }
	
	public function generateDateList($d) 
	{
		$isCurrentDay = (date('Y-m-d') == $this->getDateMainform()?true:false);
		return [	//fucking beatch
				'firstDay' => [
						'uriFormat' => date("d/m/Y", strtotime("-3 day", strtotime($this->getDateMainform()))),
						],
				'dayBeforeYesterday' => [
						'uriFormat' => date("d/m/Y", strtotime("-2 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?'day before yesterday':date("d.m.Y", strtotime("-2 day", strtotime($this->getDateMainform())))
						],
				'yesterday' => [
						'uriFormat' => date("d/m/Y", strtotime("-1 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?'yesterday':date("d.m.Y", strtotime("-1 day", strtotime($this->getDateMainform())))
						],
				'tomorrow' => [
						'uriFormat' => date("d/m/Y", strtotime("+1 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?'tomorrow':date("d.m.Y", strtotime("+1 day", strtotime($this->getDateMainform())))
						],
				'dayAfterTomorrow' => [
						'uriFormat' => date("d/m/Y", strtotime("+2 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?'day after tomorrow':date("d.m.Y", strtotime("+2 day", strtotime($this->getDateMainform())))
						],
				'lastDay' => [
						'uriFormat' => date("d/m/Y", strtotime("+3 day", strtotime($this->getDateMainform()))),
						]						
				];
	}
}
