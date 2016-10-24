<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;
use Route;

class CategoriesController extends Controller
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
		$cat_expenses = Category::where('is_system', '=', true) //категории расходов
								->where('is_plus', '=', false)
								->orWhere('user_id', Auth::user()->id)
								->orderBy('name')
								->get(array('id', 'name', 'description', 'is_visible', 'is_plus', 'is_system', 'parent_id'));
								
		$cat_gain = Category::where('is_system', '=', true)	//категории доходов
								->where('is_plus', '=', true)
								->orWhere('user_id', Auth::user()->id)
								->orderBy('name')
								->get(array('id', 'name', 'description', 'is_visible', 'is_plus', 'is_system', 'parent_id'));
		
		$data = [
				'selected_menu' => 'categories',
				'cat_expenses' => $this->createCategoryTree($cat_expenses),
				'cat_gain' => $cat_gain
				];		
        return view('categories', $data);
    }
	
    public function put(Request $request)
    {
		//dd($request->input());
		if ($request->input('addCategory')) {
			$category = new Category;
			$category->parent_id = $request->input('parent_id');
			$category->name = $request->input('cat_name');
			$category->description = $request->input('categoryDescription');
			$category->is_plus = ($request->input('is_plus')?true:false);
			$category->is_visible = $request->exists('is_visible');
			$category->is_system = 0;
			
			$category->save();
		} else {
			dd(222);	//я сюда не должен попасть
		}
        
		return redirect()->route('categories');
    }
	
    public function del()
    {
		$id_category = Route::current()->parameters()['id_category'];
		$category = Category::find($id_category);
		//dd($category);
		return redirect()->route('categories');
	}	
	
	public function createCategoryTree($categories) {
		$r = array();
		foreach ($categories as $val) {
			if ($val->parent_id) {
				$r[$val->parent_id]["childs"][$val->id] = $val;
			} else {
				$r[$val->id]["parent"] = $val;
			}
		}
		return $r;
	}
}
