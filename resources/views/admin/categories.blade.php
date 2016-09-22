@extends('admin.app')

@section('content')
  
<div class="row">
	<div class="col-md-6">
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
							  <option>1</option>
							  <option>2</option>
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
					
					<div class="form-group{{ $errors->has('isPlus') ? ' has-error' : '' }}">
						<label for="isPlus" class="col-md-4 control-label">isPlus</label>
						<div class="col-md-6">
							<select class="form-control" id="isPlus" name="isPlus">
							  <option>1</option>
							  <option>2</option>
							</select>
							<span class="help-block">1 = Доход, 2 = Расход</span>
							@if ($errors->has('isPlus'))
								<span class="help-block">
									<strong>{{ $errors->first('isPlus') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('isVisible') ? ' has-error' : '' }}">
						<label for="isVisible" class="col-md-4 control-label">isVisible</label>
						<div class="col-md-6 checkbox">
							<label>
								<input type="checkbox" name="isVisible" id="isVisible" value="isVisible">
								isVisible
							</label>

							@if ($errors->has('isVisible'))
								<span class="help-block">
									<strong>{{ $errors->first('isVisible') }}</strong>
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
</div>


@endsection	