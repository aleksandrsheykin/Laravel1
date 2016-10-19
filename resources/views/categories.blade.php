@extends('layouts.app')

@section('content')
<script>
	function deleteCategory(id_cat, cat_name, confirm) {
		$('#modalDelete').modal();
		document.getElementById('delete-category-name').innerHTML = can_name;
		/*if (confirm > 0) {
			event.preventDefault(); 
			document.getElementById('cat_del_form_'+id_cat).submit();
		} else {	//показать модальный диалог подтверждения удаления
			document.getElementById('id_category_for_delete').innerHTML = '<a href="#" onclick="deleteCategory('+id_cat+', 0, 1);">delete '+cat_name+'</a>';
			$("#delete_confirmation").show();
		}
		return false;*/
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
						@if (isset($cat_expenses))
							<table class="table table-hover">
								@foreach ($cat_expenses as $cat)
									@if (isset($cat['parent']))	{{-- Есть ли родитель (если нет, то путаница какая-то произошла) --}}
										<tr class="active">
											<td style="width: 30%;">{{ $cat['parent']->name }}</td>
											<td>{{ $cat['parent']->description }}</td>
											<td class="text-right">
												<div class="btn-group">
													<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"><span class="caret"></span></button>
													<ul class="dropdown-menu">
														<li>
															<a href="#" onclick="editCategory({{ $cat['parent']->id }}, '{{ $cat['parent']->name }}', '{{ $cat['parent']->description }}', {{ $cat['parent']->is_plus }}, {{ $cat['parent']->is_visible }}, {{$cat['parent']->parent_id}});">{{ trans('home.edit') }}</a>
														</li>
														<li>
															<a href="#" onclick="deleteCategory({{ $cat['parent']->id }}, '{{ $cat['parent']->name }}', 0);">{{ trans('home.delete') }}</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
									@endif
									@if (isset($cat['childs']))	{{-- Если есть дети, то выводим --}}
										@foreach ($cat['childs'] as $child)
											<tr>
												<td style="width: 30%; padding-left: 30px;">{{ $child->name }}</td>
												<td style="padding-left: 30px;">{{ $child->description }}</td>
												<td class="text-right">
													<div class="btn-group">
														<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"><span class="caret"></span></button>
														<ul class="dropdown-menu">
															<li>
																<a href="#" onclick="editCategory({{ $child->id }}, '{{ $child->name }}', '{{ $child->description }}', {{ $child->is_plus }}, {{ $child->is_visible }}, {{ $child->parent_id}});">{{ trans('home.edit') }}</a>
															</li>
															<li>
																<a href="#" onclick="deleteCategory({{ $child->id }}, '{{ $child->name }}', 0);">{{ trans('home.delete') }}</a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
										@endforeach
									@endif
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
								<!-- form1 -->
								<form role="form" method="POST" action="{{ route('categories') }}">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<select style="display: none;" id="is_plus" name="is_plus">
										<option value="1" selected>1</option>
									</select>
									
									<div class="form-group">
										<select class="form-control" id="parent_id" name="parent_id">
											<option value="0">{{ trans('home.parent category') }}</option>
											@if (isset($cat_expenses))
												@foreach ($cat_expenses as $cat)
													@if (isset($cat['parent']))
														<option value="{{ $cat['parent']->id }}">{{ $cat['parent']->name }}</option>
													@endif
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
									<div class="form-group">
										<label>
											<input type="checkbox" name="is_visible" id="is_visible" value="is_visible" checked>
											Видимая
										</label>
										<span class="help-block">
											<strong>Показывать в общем списке (можно отключить категории которые Вы перестали использовать)</strong>
										</span>										
									</div>
									<button type="submit" value="addCategory" name="addCategory" class="btn btn-primary">{{ trans('home.add') }}</button>
								</form>				
								<!-- form1 -->
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
								<!-- form2 -->
								<form role="form" method="POST" action="{{ route('categories') }}">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<select style="display: none;" id="is_plus" name="is_plus">
										<option value="0" selected>2</option>
									</select>
									
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
								<!-- form2 -->
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

<!-- Modal on Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">{{ trans('home.confirmation delete') }}</h4>
			</div>
			<div class="modal-body" id="modal-body">
				Удалить категорию <label id="delete-category-name">name</label>? 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.close') }}</button>
				<button type="button" class="btn btn-danger">{{ trans('home.delete') }}</button>
			</div>
		</div>
	</div>
</div>
@endsection


