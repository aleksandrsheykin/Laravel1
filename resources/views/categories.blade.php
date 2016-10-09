@extends('layouts.app')

@section('content')
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
						//
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


