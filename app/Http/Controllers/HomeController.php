<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use Auth;
use StaticFunctions;

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
		return $this->date_mainform;	//Y-m-d
	}	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		//dd();
		//StaticFunctions::testfunc();
		$data = [
                'date_mainform' => $this->getDateMainform(),
				'date_list_for_uri' => $this->generateDateList(),
				'selected_menu' => 'home',
				'cat_expenses' => Auth::User()->getCategories()->where('is_plus', '=', false)->get(),
				'cat_gain' => Auth::User()->getCategories()->where('is_plus', '=', true)->get()
				];		
        return view('home', $data);
    }
	
	public function generateDateList() 
	{
		$isCurrentDay = (date('Y-m-d') == $this->getDateMainform()?true:false);
		return [	//fucking beatch
				'firstDay' => [
						'uriFormat' => date("d/m/Y", strtotime("-3 day", strtotime($this->getDateMainform()))),
						],
				'dayBeforeYesterday' => [
						'uriFormat' => date("d/m/Y", strtotime("-2 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?trans('home.day before yesterday'):date("d.m.Y", strtotime("-2 day", strtotime($this->getDateMainform())))
						],
				'yesterday' => [
						'uriFormat' => date("d/m/Y", strtotime("-1 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?trans('home.yesterday'):date("d.m.Y", strtotime("-1 day", strtotime($this->getDateMainform())))
						],
				'tomorrow' => [
						'uriFormat' => date("d/m/Y", strtotime("+1 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?trans('home.tomorrow'):date("d.m.Y", strtotime("+1 day", strtotime($this->getDateMainform())))
						],
				'dayAfterTomorrow' => [
						'uriFormat' => date("d/m/Y", strtotime("+2 day", strtotime($this->getDateMainform()))),
						'niceFormat' => $isCurrentDay?trans('home.day after tomorrow'):date("d.m.Y", strtotime("+2 day", strtotime($this->getDateMainform())))
						],
				'lastDay' => [
						'uriFormat' => date("d/m/Y", strtotime("+3 day", strtotime($this->getDateMainform()))),
						]						
				];
	}
}
