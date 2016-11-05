@extends('layouts.app')

@section('content')
<script>
	$(document).ready(function(){
		$('.nav-tabs a[href="#'+getCookie('active_tab')+'"]').tab('show');
		
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			var active_tab = String(e.target).split('#')[1]; // активна€ вкладка
			setCookie('active_tab', active_tab);
		});	
	});

	function deleteCategory(id_cat, cat_name, url) {
		$('#modalDelete').modal();
		document.getElementById('delete-category-name').innerHTML = cat_name;	//был бухой
		$('#delete-button').attr('action', url);
		return false;
	}
	
	function editCategory(id_cat, name, description, is_plus, is_visible, parent_id, is_expenses) {	
		if (is_expenses) {
			pref = "expenses";
		} else {
			pref = "gain";
		}
		$("#form_add_"+pref).hide();
		$("#form_edit_"+pref).show();
		
		$("#edit_id_cat_"+pref).val(id_cat);
		$("#edit_parent_id_"+pref).val(parent_id);
		$("#edit_cat_name_"+pref).val(name);
		$("#edit_categoryDescription_"+pref).val(description);
		$("#edit_is_visible_"+pref).prop("checked", is_visible);
		return false;
	}
	
	function editClose(is_expenses) {
		if (is_expenses) {
			pref = "expenses";
		} else {
			pref = "gain";
		}
		$("#form_edit_"+pref).hide();
		$("#form_add_"+pref).show();
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
		<div class="tab-content" id="tab_panel">
			<div class="tab-pane active" id="expenses" style="padding-top: 10px;">
				<div class="row">
					<div class="col-md-7">	<!-- list expenses -->
						@if (isset($cat_expenses))
							<table class="table table-hover">
								@foreach ($cat_expenses as $cat)
									@if (isset($cat['parent']))	{{-- ≈сть ли родитель (если нет, то путаница кака€-то произошла) --}}
										<tr class="active">
											<td style="width: 30%;">{{ $cat['parent']->name }}</td>
											<td>{{ $cat['parent']->description }}</td>
											<td class="text-right" style="min-width: 55px;">
												@if (!$cat['parent']->is_visible)
													<div class="btn-group">
														<span class="glyphicon glyphicon-eye-close"></span>
													</div>
												@endif
												<div class="btn-group">
													@if (!$cat['parent']->is_system)
														<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"><span class="caret"></span></button>
														<ul class="dropdown-menu">
															<li>
																<a href="#" onclick="editCategory({{ $cat['parent']->id }}, '{{ $cat['parent']->name }}', '{{ $cat['parent']->description }}', {{ $cat['parent']->is_plus }}, {{ $cat['parent']->is_visible }}, {{$cat['parent']->parent_id}}, 1);">{{ trans('home.edit') }}</a>
															</li>
															<li>
																<a href="#" onclick="deleteCategory({{ $cat['parent']->id }}, '{{ $cat['parent']->name }}', '{{ Route('categoriesDel', ['id_category' => $cat['parent']->id]) }}');">{{ trans('home.delete') }}</a>
															</li>
														</ul>
													@endif
												</div>
											</td>
										</tr>
									@endif
									@if (isset($cat['childs']))	{{-- ≈сли есть дети, то выводим --}}
										@foreach ($cat['childs'] as $child)
											<tr>
												<td style="width: 30%; padding-left: 30px;">{{ $child->name }}</td>
												<td style="padding-left: 30px;">{{ $child->description }}</td>
												<td class="text-right" style="min-width: 55px;">
													<div>
													@if (!$child->is_visible)
														<div class="btn-group">
															<span class="glyphicon glyphicon-eye-close"></span>
														</div>
													@endif
													@if (!$child->is_system)
														<div class="btn-group">
															<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"><span class="caret"></span></button>
															<ul class="dropdown-menu">
																<li>
																	<a href="#" onclick="editCategory({{ $child->id }}, '{{ $child->name }}', '{{ $child->description }}', {{ $child->is_plus }}, {{ $child->is_visible }}, {{ $child->parent_id}}, 1);">{{ trans('home.edit') }}</a>
																</li>
																<li>
																	<a href="#" onclick="deleteCategory({{ $child->id }}, '{{ $child->name }}', '{{ Route('categoriesDel', ['id_category' => $child->id]) }}');">{{ trans('home.delete') }}</a>
																</li>
															</ul>
														</div>															
													@endif
													</div>
												</td>
											</tr>
										@endforeach
									@endif
								@endforeach
							</table>							
						@else
							<div class="alert alert-danger">
								{{ trans('home.category not found') }}
							</div>
						@endif
					</div>
					<div class="col-md-5">	<!-- forms expenses -->

						<div class="panel panel-default" id="form_add_expenses">
							<div class="panel-heading">{{ trans('home.add category') }}</div>
							<div class="panel-body">
								<!-- form add 1 -->
								<form role="form" method="POST" action="{{ route('categories') }}">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<select style="display: none;" id="is_plus_expenses" name="is_plus">
										<option value="0" selected>1</option>
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
											{{ trans('home.visible') }} <span class="glyphicon glyphicon-eye-close"></span>
										</label>
										<span class="help-block">
											<strong>{{ trans('home.Show in the list (you can disable the category that you no longer use)') }}</strong>
										</span>										
									</div>
									<button type="submit" value="addCategory" name="addCategory" class="btn btn-primary">{{ trans('home.add') }}</button>
								</form>				
								<!-- form add 1 -->
							</div>
						</div>

						<div class="panel panel-default" id="form_edit_expenses" style="display: none;">
							<div class="panel-heading">{{ trans('home.alter category') }}</div>
							<div class="panel-body">
								<!-- form edit 1 -->
								<form role="form" method="POST" action="{{ route('editCategory') }}">
									{{ csrf_field() }}
									{{ method_field('OPTIONS') }}
									<select style="display: none;" id="is_plus" name="is_plus">
										<option value="1" selected>1</option>
									</select>
									<input type="hidden" value="" id="edit_id_cat_expenses" name="edit_id_cat" />
									
									<div class="form-group">
										<select class="form-control" id="edit_parent_id_expenses" name="edit_parent_id">
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
										<input type="text" class="form-control" id="edit_cat_name_expenses" name="edit_cat_name" placeholder="{{ trans('home.name') }}*" required>
									</div>
									<div class="form-group">
										<textarea class="form-control" rows="3" id="edit_categoryDescription_expenses" name="edit_categoryDescription" placeholder="{{ trans('home.description') }}">{{ old('categoryDescription') }}</textarea>
									</div>
									<div class="form-group">
										<label>
											<input type="checkbox" name="edit_is_visible" id="edit_is_visible_expenses" value="is_visible" checked>
											{{ trans('home.visible') }} <span class="glyphicon glyphicon-eye-close"></span>
										</label>
										<span class="help-block">
											<strong>{{ trans('home.Show in the list (you can disable the category that you no longer use)') }}</strong>
										</span>
									</div>
									<button type="submit" value="editCategory" name="editCategory" class="btn btn-success">{{ trans('home.save') }}</button>
									<button type="button" class="btn btn-danger" onclick="editClose(1); return false;">{{ trans('home.cancel') }}</button>
								</form>
								<!-- form edit 1 -->
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<!-- <<<TAB1<<<.-------.------.>>>TAB2>>>-->
			<div class="tab-pane" id="gain" style="padding-top: 10px;">
				<div class="row">
					<div class="col-md-7">	<!-- list gain -->
						@if (isset($cat_gain))
							<table class="table table-hover">
								@foreach ($cat_gain as $cat)
									@if (isset($cat['parent']))	{{-- ≈сть ли родитель (если нет, то путаница кака€-то произошла) --}}
										<tr class="active">
											<td style="width: 30%;">{{ $cat['parent']->name }}</td>
											<td>{{ $cat['parent']->description }}</td>
											<td class="text-right" style="min-width: 55px;">
												@if (!$cat['parent']->is_visible)
													<div class="btn-group">
														<span class="glyphicon glyphicon-eye-close"></span>
													</div>
												@endif
												<div class="btn-group">
													@if (!$cat['parent']->is_system)
														<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"><span class="caret"></span></button>
														<ul class="dropdown-menu">
															<li>
																<a href="#" onclick="editCategory({{ $cat['parent']->id }}, '{{ $cat['parent']->name }}', '{{ $cat['parent']->description }}', {{ $cat['parent']->is_plus }}, {{ $cat['parent']->is_visible }}, {{$cat['parent']->parent_id}}, 0);">{{ trans('home.edit') }}</a>
															</li>
															<li>
																<a href="#" onclick="deleteCategory({{ $cat['parent']->id }}, '{{ $cat['parent']->name }}', '{{ Route('categoriesDel', ['id_category' => $cat['parent']->id]) }}');">{{ trans('home.delete') }}</a>
															</li>
														</ul>
													@endif
												</div>
											</td>
										</tr>
									@endif
									@if (isset($cat['childs']))	{{-- ≈сли есть дети, то выводим --}}
										@foreach ($cat['childs'] as $child)
											<tr>
												<td style="width: 30%; padding-left: 30px;">{{ $child->name }}</td>
												<td style="padding-left: 30px;">{{ $child->description }}</td>
												<td class="text-right" style="min-width: 55px;">
													@if (!$child->is_visible)
														<div class="btn-group">
															<span class="glyphicon glyphicon-eye-close"></span>
														</div>
													@endif												
													@if (!$child->is_system)
														<div class="btn-group">
															<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown"><span class="caret"></span></button>
															<ul class="dropdown-menu">
																<li>
																	<a href="#" onclick="editCategory({{ $child->id }}, '{{ $child->name }}', '{{ $child->description }}', {{ $child->is_plus }}, {{ $child->is_visible }}, {{ $child->parent_id}}, 0);">{{ trans('home.edit') }}</a>
																</li>
																<li>
																	<a href="#" onclick="deleteCategory({{ $child->id }}, '{{ $child->name }}', '{{ Route('categoriesDel', ['id_category' => $child->id]) }}');">{{ trans('home.delete') }}</a>
																</li>
															</ul>
														</div>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								@endforeach
							</table>							
						@else
							<div class="alert alert-danger">
								{{ trans('home.category not found') }}
							</div>
						@endif
					</div>
					<div class="col-md-5">	<!-- forms gain -->
					
						<div class="panel panel-default" id="form_add_gain">
							<div class="panel-heading">{{ trans('home.add category') }}</div>
							<div class="panel-body">
								<!-- form add 1 -->
								<form role="form" method="POST" action="{{ route('categories') }}">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<select style="display: none;" id="is_plus" name="is_plus">
										<option value="1" selected>1</option>
									</select>
									
									<div class="form-group">
										<select class="form-control" id="parent_id" name="parent_id">
											<option value="0">{{ trans('home.parent category') }}</option>
											@if (isset($cat_gain))
												@foreach ($cat_gain as $cat)
													@if (isset($cat['parent']))
														<option value="{{ $cat['parent']->id }}">{{ $cat['parent']->name }}</option>
													@endif
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
									<div class="form-group">
										<label>
											<input type="checkbox" name="is_visible" id="is_visible" value="is_visible" checked>
											{{ trans('home.visible') }} <span class="glyphicon glyphicon-eye-close"></span>
										</label>
										<span class="help-block">
											<strong>{{ trans('home.Show in the list (you can disable the category that you no longer use)') }}</strong>
										</span>										
									</div>
									<button type="submit" value="addCategory" name="addCategory" class="btn btn-primary">{{ trans('home.add') }}</button>
								</form>				
								<!-- form add 1 -->
							</div>
						</div>

						<div class="panel panel-default" id="form_edit_gain" style="display: none;">
							<div class="panel-heading">{{ trans('home.alter category') }}</div>
							<div class="panel-body">
								<!-- form edit 1 -->
								<form role="form" method="POST" action="{{ route('editCategory') }}">
									{{ csrf_field() }}
									{{ method_field('OPTIONS') }}
									<select style="display: none;" id="is_plus" name="is_plus">
										<option value="0" selected>1</option>
									</select>
									<input type="hidden" value="" id="edit_id_cat_gain" name="edit_id_cat" />
									
									<div class="form-group">
										<select class="form-control" id="edit_parent_id_gain" name="edit_parent_id">
											<option value="0">{{ trans('home.parent category') }}</option>
											@if (isset($cat_gain))
												@foreach ($cat_gain as $cat)
													@if (isset($cat['parent']))
														<option value="{{ $cat['parent']->id }}">{{ $cat['parent']->name }}</option>
													@endif
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="edit_cat_name_gain" name="edit_cat_name" placeholder="{{ trans('home.name') }}*" required>
									</div>
									<div class="form-group">
										<textarea class="form-control" rows="3" id="edit_categoryDescription_gain" name="edit_categoryDescription" placeholder="{{ trans('home.description') }}">{{ old('categoryDescription') }}</textarea>
									</div>
									<div class="form-group">
										<label>
											<input type="checkbox" name="edit_is_visible" id="edit_is_visible_gain" value="is_visible" checked>
											{{ trans('home.visible') }} <span class="glyphicon glyphicon-eye-close"></span>
										</label>
										<span class="help-block">
											<strong>{{ trans('home.Show in the list (you can disable the category that you no longer use)') }}</strong>
										</span>
									</div>
									<button type="submit" value="editCategory" name="editCategory" class="btn btn-success">{{ trans('home.save') }}</button>
									<button type="button" class="btn btn-danger" onclick="editClose(0); return false;">{{ trans('home.cancel') }}</button>
								</form>
								<!-- form edit 1 -->
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
				”далить категорию <label id="delete-category-name">name</label>? 
			</div>
			<div class="modal-footer">
				<form action="" id="delete-button">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.close') }}</button>
					<button type="submit" class="btn btn-danger">{{ trans('home.delete') }}</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

