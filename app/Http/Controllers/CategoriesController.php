<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;
use Route;
use App\User;
use StaticFunctions;

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
		$cat_expenses = Category::where('user_id', Auth::user()->id) //категории расходов
								->where('is_plus', '=', false)
								->orderBy('name')
								->get(array('id', 'name', 'description', 'is_visible', 'is_plus', 'is_system', 'parent_id'));
								
		$cat_gain = Category::where('user_id', Auth::user()->id)	//категории доходов
								->where('is_plus', '=', true)
								->orderBy('name')
								->get(array('id', 'name', 'description', 'is_visible', 'is_plus', 'is_system', 'parent_id'));
		
		//dd($cat_expenses);
		$data = [
				'selected_menu' => 'categories',
				'cat_expenses' => StaticFunctions::createCategoryTree($cat_expenses),
				'cat_gain' => StaticFunctions::createCategoryTree($cat_gain),
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

	public function edit(Request $request) {
		if ($request->input('editCategory')) {
			$user_id = Auth::User()->id;
			$category_owner = Category::where('id', '=', $request->input('edit_id_cat'))->get(array('user_id'))[0]->user_id;

			if ($category_owner == $user_id) {	//если категория принадлежит авторизованному пользователю, то можно редактировать
				$new_values = [
							'parent_id'=> $request->input('edit_parent_id'), 
							'name'=> $request->input('edit_cat_name'), 
							'description'=> $request->input('edit_categoryDescription'), 
							'is_visible'=> $request->exists('edit_is_visible')
							];				
				$category = Category::where('id', '=' , $request->input('edit_id_cat'))->update($new_values);
			}
		} else {
			dd(333);
		}
		return redirect()->route('categories');
	}	
	
}
