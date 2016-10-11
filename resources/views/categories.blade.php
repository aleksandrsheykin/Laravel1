@extends('layouts.app')

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
		$("#edit_categoryName").val(name);
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
	<div class="col-md-9 col-xs-12 col-md-push-3"> <!-- content -->
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#expenses" class="bg-danger" data-toggle="tab">{{ trans('home.expenses') }}</a></li>
			<li><a href="#gain" class="bg-success" data-toggle="tab">{{ trans('home.gain') }}</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

			<div class="tab-pane active" id="expenses" style="padding-top: 10px;">
				<div class="row">
					<div class="col-md-7">
							@if (isset($categories))
								<table class="table table-hover">				
									@foreach ($categories as $cat)
										<tr>
											<td>{{ $cat->name }}</td>
											<td>{{ $cat->description }}</td>
											<td>{{ $cat->is_visible }}</td>
											<td class="text-right">
												<a href="#" onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->description }}', {{ $cat->is_plus }}, {{ $cat->is_visible }}, {{$cat->parent_id}});">{{ trans('home.edit') }}</a>
												|
												<a href="#" onclick="deleteCategory({{ $cat->id }}, '{{ $cat->name }}', 0);">{{ trans('home.delete') }}</a>
											</td>
										</tr>	
									@endforeach
								</table>							
							@else
							//	
							@endif
					</div>
					<div class="col-md-5">
						<div class="panel panel-default">
							<div class="panel-heading">{{ trans('home.add category') }}</div>
							<div class="panel-body">
								<!-- form1-->
								<form role="form" method="POST" action="{{ route('categories') }}">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<select style="display: none;" id="is_plus" name="is_plus">
										<option value="1" selected>1</option>
									</select>
									<input type="hidden" name="is_visible" id="is_visible" value="is_visible" checked>
									
									<div class="form-group">
										<select class="form-control" id="parent_id" name="parent_id">
											<option value="0">{{ trans('home.parent category') }}</option>
											@if (isset($category))
												@foreach ($category as $cat)
													<option value="{{ $cat->id }}">{{ $cat->name }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="{{ trans('home.name') }}*" required autofocus>
									</div>
									<div class="form-group">
										<textarea class="form-control" rows="3" id="categoryDescription" name="categoryDescription" placeholder="{{ trans('home.description') }}">{{ old('categoryDescription') }}</textarea>
									</div>
									<button type="submit" class="btn btn-primary">{{ trans('home.add') }}</button>
								</form>				
								<!-- form1-->
							</div>
						</div>
					</div>						
				</div>
			</div>
			<!-- <<<TAB1<<<.-------.------.>>>TAB2>>>-->
			<div class="tab-pane" id="gain" style="padding-top: 10px;">
				<div class="row">
					<div class="col-md-7">
						//
					</div>
					<div class="col-md-5">
						<div class="panel panel-default">
							<div class="panel-heading">{{ trans('home.add category') }}</div>
							<div class="panel-body">
								<!-- form2-->
								<form role="form" method="POST" action="{{ route('categories') }}">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<select style="display: none;" id="is_plus" name="is_plus">
										<option value="0" selected>2</option>
									</select>
									<input type="hidden" name="is_visible" id="is_visible" value="is_visible" checked>
									
									<div class="form-group">
										<select class="form-control" id="parent_id" name="parent_id">
											<option value="0">{{ trans('home.parent category') }}</option>
											@if (isset($category))
												@foreach ($category as $cat)
													<option value="{{ $cat->id }}">{{ $cat->name }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="{{ trans('home.name') }}*" required>
									</div>
									<div class="form-group">
										<textarea class="form-control" rows="3" id="categoryDescription" name="categoryDescription" placeholder="{{ trans('home.description') }}">{{ old('categoryDescription') }}</textarea>
									</div>
									<button type="submit" class="btn btn-primary">{{ trans('home.add') }}</button>
								</form>				
								<!-- form2-->
							</div>
						</div>
					</div>						
				</div>
			</div>
			
		</div>

	</div>
	
	<div class="col-md-3 col-xs-12 col-md-pull-9"> <!-- left column -->
		@include('layouts.leftmenu')
	</div>
	
</div>
@endsection


