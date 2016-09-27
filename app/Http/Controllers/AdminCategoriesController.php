<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Gate;
use App\User;
Use App\Category;

class AdminCategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function index()
    {
        $category = Category::where('is_system', '=', true)->get(array('id', 'name', 'description', 'is_visible', 'is_plus', 'is_system'));
		//dd($category);
		$data = [
                'selected_menu' => 'Categories',
				'category' => $category
				];
		return view('admin.categories', $data);
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
	
    public function del(Request $request) {

		//dd($request->input());
		if ($request->input('action')) {
			if ($request->input('action') == 'delete_category') {	//что делаем? Категорию удаляем
				Category::destroy($request->input('cat_id'));
			}
		} else {
			dd(11);	//сюда тоже не должен попасть
		}
		
		
		return $this->index();
	}	
	
}