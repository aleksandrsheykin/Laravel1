@extends('admin.app')

@section('content')

<script>
	function deleteCategory(id_cat, cat_name, confirm) {
		if (confirm > 0) {
			event.preventDefault(); 
			document.getElementById('cat_del_form_'+id_cat).submit();
		} else {	//показать диалог подтверждения удаления
			document.getElementById('id_category_for_delete').innerHTML = '<a href="#" onclick="deleteCategory('+id_cat+', 0, 1);">delete '+cat_name+'</a>';
			$("#delete_confirmation").show();
		}
		return false;
	}
	
	function editCategory(id_cat, name, description, is_plus, is_visible, parent_id) {
		$("#form_add_cat").hide();
		$("#form_edit_cat").show();
		
		$("#edit_id_cat").val(id_cat);
		$("#edit_parent_id").val(parent_id);
		$("#edit_categoryName").val("Delete "+name);
		$("#edit_categoryDescription").val(description);
		$("#edit_is_plus").val(is_plus);
		$("#edit_is_visible").prop("checked", is_visible);
		
		$("#delete_confirmation").hide();
		return false;
	}
	
	function editClose() {
		$("#form_edit_cat").hide();
		$("#form_add_cat").show();
	}
</script>
  
<div class="row">

	<div class="col-md-8">
		<div class="panel panel-warning" id="delete_confirmation" style="display: none;">
			<div class="panel-heading">Confirmation delete category</div>
			<div class="panel-body">
				Delete this category? 
				<label id="id_category_for_delete"><a href="#" onclick="deleteCategory({1, '', 1);">name</a></label>
				|
				<label><a href="#" onclick="$('#delete_confirmation').hide();">no</a></label>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>description</th>
					<th>is_plus</th>
					<th>is_visible</th>
					<th>is_system</th>
					<th>parent_id</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
					@if (isset($category))
						@foreach ($category as $cat)
						<tr>
							<td>{{ $cat->id }}</td>
							<td>{{ $cat->name }}</td>
							<td>{{ $cat->description }}</td>
							<td>{{ $cat->is_plus }}</td>
							<td>{{ $cat->is_visible }}</td>
							<td>{{ $cat->is_system }}</td>
							<td>{{ $cat->parent_id }}</td>
							<td>
								<a href="#" onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->description }}', {{ $cat->is_plus }}, {{ $cat->is_visible }}, {{$cat->parent_id}});">
									edit
								</a>	
								|
								<a href="#" onclick="deleteCategory({{ $cat->id }}, '{{ $cat->name }}', 0);">
									delete
								</a>
								<form id="cat_del_form_{{ $cat->id }}" action="{{ Route('adminCategoriesDel') }}" method="POST" style="display: none;">
									{{ method_field('DELETE') }}
									{{ csrf_field() }}
									<input type="hidden" name="cat_id" id="cat_id" value="{{ $cat->id }}">
									<input type="hidden" name="action" id="action" value="delete_category">
								</form>								
							</td>
						</tr>        
						@endforeach
					@endif
				</tbody>
			</table>
		</div>		
	</div>	
	
	<div class="col-md-4">
		<div class="panel panel-default" id="form_add_cat"> 
			<div class="panel-heading">Add Start Category</div>
			<div class="panel-body">
				<form class="form-horizontal" method="POST" action="{{ route('adminCategories') }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					
					<div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
						<label for="parent_id" class="col-md-4 control-label">parent_id</label>
						<div class="col-md-6">
							<select class="form-control" id="parent_id" name="parent_id">
								<option value="0">0</option>
								@if (isset($category))
									@foreach ($category as $cat)
										<option value="{{ $cat->id }}">{{ $cat->name }}</option>
									@endforeach
								@endif
							</select>
							<span class="help-block">Родитель</span>
							@if ($errors->has('parent_id'))
								<span class="help-block">
									<strong>{{ $errors->first('parent_id') }}</strong>
								</span>
							@endif
						</div>
					</div>					
					
					<div class="form-group{{ $errors->has('categoryName') ? ' has-error' : '' }}">
						<label for="categoryName" class="col-md-4 control-label">Name</label>
						<div class="col-md-6">
							<input type="text" name="categoryName" class="form-control" id="categoryName" placeholder="categoryName"  value="{{ old('categoryName') }}" required autofocus>
							@if ($errors->has('categoryName'))
								<span class="help-block">
									<strong>{{ $errors->first('categoryName') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('categoryDescription') ? ' has-error' : '' }}">
						<label for="categoryDescription" class="col-md-4 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" rows="3" id="categoryDescription" name="categoryDescription" placeholder="categoryDescription">{{ old('categoryDescription') }}</textarea>
							@if ($errors->has('categoryDescription'))
								<span class="help-block">
									<strong>{{ $errors->first('categoryDescription') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('is_plus') ? ' has-error' : '' }}">
						<label for="is_plus" class="col-md-4 control-label">is_plus</label>
						<div class="col-md-6">
							<select class="form-control" id="is_plus" name="is_plus">
							  <option value="1">Доход</option>
							  <option value="0">Расход</option>
							</select>
							@if ($errors->has('is_plus'))
								<span class="help-block">
									<strong>{{ $errors->first('is_plus') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('is_visible') ? ' has-error' : '' }}">
						<label for="is_visible" class="col-md-4 control-label">is_visible</label>
						<div class="col-md-6 checkbox">
							<label>
								<input type="checkbox" name="is_visible" id="is_visible" value="is_visible" checked>
								is_visible
							</label>

							@if ($errors->has('is_visible'))
								<span class="help-block">
									<strong>{{ $errors->first('is_visible') }}</strong>
								</span>
							@endif
						</div>
					</div>						
					
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" value="addCategory" name="addCategory" class="btn btn-primary">Добавить</button>
						</div>
					</div>
					
				</form>
			</div>
		</div>
		
		<div class="panel panel-default" id="form_edit_cat" style="display: none;"> 
			<div class="panel-heading">Edit Category</div>
			<div class="panel-body">
				<form class="form-horizontal" method="POST" action="{{ route('adminCategories') }}">
					{{ csrf_field() }}
					{{ method_field('OPTIONS') }}
					<input type="hidden" name="edit_id_cat" id="edit_id_cat" value="" >
					<div class="form-group{{ $errors->has('edit_parent_id') ? ' has-error' : '' }}">
						<label for="edit_parent_id" class="col-md-4 control-label">parent_id</label>
						<div class="col-md-6">
							<select class="form-control" id="edit_parent_id" name="edit_parent_id">
								<option value="0">0</option>
								@if (isset($category))
									@foreach ($category as $cat)
										<option value="{{ $cat->id }}">{{ $cat->name }}</option>
									@endforeach
								@endif
							</select>
							<span class="help-block">Родитель</span>
							@if ($errors->has('edit_parent_id'))
								<span class="help-block">
									<strong>{{ $errors->first('edit_parent_id') }}</strong>
								</span>
							@endif
						</div>
					</div>					
					
					<div class="form-group{{ $errors->has('edit_categoryName') ? ' has-error' : '' }}">
						<label for="edit_categoryName" class="col-md-4 control-label">Name</label>
						<div class="col-md-6">
							<input type="text" name="edit_categoryName" class="form-control" id="edit_categoryName" placeholder="edit_categoryName"  value="{{ old('categoryName') }}" required autofocus>
							@if ($errors->has('edit_categoryName'))
								<span class="help-block">
									<strong>{{ $errors->first('edit_categoryName') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('edit_categoryDescription') ? ' has-error' : '' }}">
						<label for="edit_categoryDescription" class="col-md-4 control-label">Description</label>
						<div class="col-md-6">
							<textarea class="form-control" rows="3" id="edit_categoryDescription" name="edit_categoryDescription" placeholder="categoryDescription">{{ old('categoryDescription') }}</textarea>
							@if ($errors->has('edit_categoryDescription'))
								<span class="help-block">
									<strong>{{ $errors->first('edit_categoryDescription') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('edit_is_plus') ? ' has-error' : '' }}">
						<label for="edit_is_plus" class="col-md-4 control-label">is_plus</label>
						<div class="col-md-6">
							<select class="form-control" id="edit_is_plus" name="edit_is_plus">
							  <option value="1">Доход</option>
							  <option value="0">Расход</option>
							</select>
							@if ($errors->has('edit_is_plus'))
								<span class="help-block">
									<strong>{{ $errors->first('edit_is_plus') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('edit_is_visible') ? ' has-error' : '' }}">
						<label for="edit_is_visible" class="col-md-4 control-label">is_visible</label>
						<div class="col-md-6 checkbox">
							<label>
								<input type="checkbox" name="edit_is_visible" id="edit_is_visible" value="edit_is_visible">
								is_visible
							</label>

							@if ($errors->has('edit_is_visible'))
								<span class="help-block">
									<strong>{{ $errors->first('edit_is_visible') }}</strong>
								</span>
							@endif
						</div>
					</div>						
					
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" value="editCategory" name="editCategory" class="btn btn-success">Save</button>
							<button type="submit" class="btn btn-danger" onclick="editClose(); return false;">Close</button>
						</div>
					</div>
					
				</form>
			</div>
		</div>		
	</div>
	
</div>	<!--row -->

<div class="row">

</div>

@endsection	