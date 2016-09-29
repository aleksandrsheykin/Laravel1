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
        $category = Category::where('is_system', '=', true)->get(array('id', 'name', 'description', 'is_visible', 'is_plus', 'is_system', 'parent_id'));
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
	
	public function edit(Request $request) {
		//dd($request->input());
		if ($request->input('editCategory')) {
			$new_values = [
						'parent_id'=> $request->input('edit_parent_id'), 
						'name'=> $request->input('edit_categoryName'), 
						'description'=> $request->input('edit_categoryDescription'), 
						'is_plus'=> $request->input('edit_is_plus'), 
						'is_visible'=> $request->exists('edit_is_visible')
						];
			//dd($new_values);
			
			$category = Category::where('id', '=' , $request->input('edit_id_cat'))->update($new_values);
			//dd($category);
		} else {
			dd(333);
		}
		return $this->index();
	}
}