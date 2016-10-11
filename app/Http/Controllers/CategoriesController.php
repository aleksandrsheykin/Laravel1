<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;

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
		$categories = Category::where('is_system', '=', true)
								->orWhere('user_id', Auth::user()->id)
								->get(array('id', 'name', 'description', 'is_visible', 'is_plus', 'is_system', 'parent_id'));
		//dd($categories);
		$data = [
				'selected_menu' => 'categories',
				'categories' => $categories
				];		
        return view('categories', $data);
    }
	
    public function put(Request $request)
    {
		//dd($request->input('is_plus')?true:false);
		if ($request->input('addCategory')) {
			$category = new Category;
			$category->parent_id = $request->input('parent_id');
			$category->name = $request->input('categoryName');
			$category->description = $request->input('categoryDescription');
			$category->is_plus = ($request->input('is_plus')?true:false);
			$category->is_visible = $request->exists('is_visible');
			$category->is_system = 1;
			
			$category->save();
		} else {
			dd(222);	//я сюда не должен попасть
		}
        
		return $this->index();
    }	
}
