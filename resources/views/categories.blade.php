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
					<div class="col-md-8">
						//
					</div>
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">{{ trans('home.adding category of gain') }}</div>
							<div class="panel-body">Форма</div>
						</div>
					</div>						
				</div>
			</div>
			
			<div class="tab-pane" id="gain" style="padding-top: 10px;">
				<div class="row">
					<div class="col-md-8">
						//
					</div>
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">{{ trans('home.adding category of expenses') }}</div>
							<div class="panel-body">Форма</div>
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


