@extends('admin.app')

@section('content')

<script>
	function deleteCategory(id_cat, confirg) {
		if (confirm) {
			event.preventDefault(); 
			document.getElementById('cat_del_form_'+id_cat).submit();
		} else {	//показать диалог подтверждения удаления
			//
		}
		return false;
	}
</script>
  
<div class="row">

	<div class="col-md-8">
		<div class="panel panel-warning" id="delete_confirmation" style="display: none;">
			<div class="panel-heading">Confirmation delete category</div>
			<div class="panel-body">
				Удалить? <label></label>
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
							<td>
								<a href="{{ Route('adminCategoriesDel') }}" onclick="deleteCategory({{ $cat->id }}, 0);">
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
		<div class="panel panel-default"> 
			<div class="panel-heading">Add Start Category</div>
			<div class="panel-body">
				<form class="form-horizontal" method="POST" action="{{ route('adminCategories') }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					
					<div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
						<label for="parent_id" class="col-md-4 control-label">parent_id</label>
						<div class="col-md-6">
							<select class="form-control" id="parent_id" name="parent_id">
								@if (isset($category))
									<option value="0">-</option>
									@foreach ($category as $cat)
										<option value="{{ $cat->id }}">{{ $cat->name }}</option>
									@endforeach
								@else
									<option value="0">0</option>
								@endif
							</select>
							<span class="help-block">1 = Доход, 2 = Расход</span>
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
							<span class="help-block">1 = Доход, 2 = Расход</span>
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
	</div>
	
</div>	<!--row -->

<div class="row">

</div>

@endsection	