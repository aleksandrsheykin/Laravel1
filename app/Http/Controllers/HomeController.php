<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use Auth;
use StaticFunctions;
use App\Balance;
use App\Cash;

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
			$d = $request->input('expensesDateMainform');
			if ($d == null) {
				$d = date("d/m/Y");
			}
		}
		$this->setDateMainform($d);		
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
		//dd(intval());
		$data = [
                'date_mainform' => $this->getDateMainform(),
				'date_list_for_uri' => $this->generateDateList(),
				'selected_menu' => 'home',
				'cat_expenses' => StaticFunctions::createCategoryTree(Auth::User()->getCategories()->where('is_plus', '=', false)->get()),
				'cat_gain' => StaticFunctions::createCategoryTree(Auth::User()->getCategories()->where('is_plus', '=', true)->get())
				];		
        return view('home', $data);
    }
	
	public function indexPost(Request $request) {

		if ($request->exists('submitExpenses')) {
			$this->submitExpensesOrGain($request, 'expenses');
		} else if ($request->exists('submitGain')) {
			$this->submitExpensesOrGain($request, 'gain');
		} else {
			dd(22); //WAT?
		}
		
		return redirect()->route('home');	//добавить параметр (дату которую сохранили)
	}
	
	public function submitExpensesOrGain($r, $pref) {	//$pref = expenses or gain
		$rowCount = 0;
		if ($r->exists($pref.'RowCount')) {
			$rowCount = $r->input($pref.'RowCount');
		}
		
		for ($i=1; $i<=$rowCount; $i++) {
			$summa = intval($r->input($pref.'Summa_'.$i));
			if ($summa) {
				if ($summa == 0) { continue; }
				if ($summa < 0) { $summa = -$summa; }
			} else {
				return dd(222);
			}
			$prim = StaticFunctions::validateText($r->input($pref.'Prim_'.$i));
			$catId = StaticFunctions::validateInt($r->input($pref.'CatId_'.$i));
			if ($catId <= 0) { continue; }
			$oldId = StaticFunctions::validateInt($r->input($pref.'OldId_'.$i));
			
			if ($oldId) {	//row already exists
				//
			} else {	//row not exists
				$b = new Balance();
				$b->cash_id = Cash::getBasicCashId($pref);
				$b->summa = $summa;
				$b->description = $prim;
				$b->category_id = $catId;
				$b->datebal = $this->GetDateMainform();
				$b->user_id = Auth::User()->id;
				$b->save();
			}
			/*echo $r->input($pref.'Summa_'.$i);
			//echo 'OldId_'.$r->input($pref.'OldId_'.$i);
			echo $r->exists($pref.'OldId_'.$i);
			echo $r->input($pref.'CatId_'.$i);
			echo $r->input($pref.'Prim_'.$i);*/
		}
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
