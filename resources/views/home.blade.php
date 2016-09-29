@extends('layouts.app')

@section('content')
<div class="row">

	<div class="col-md-9 col-xs-12 col-md-push-3"> <!-- content -->
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a class="bg-warning" href="#gain" data-toggle="tab">Расходы</a></li>
			<li><a href="#expenses" class="bg-success" data-toggle="tab">Доходы</a></li>
			<li><a href="#move" class="bg-info" data-toggle="tab">Перемещения</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="gain">
				<div class="panel panel-warning">
					<div class="panel-heading text-center">
						<ul class="pagination" style="margin: 0px;">
							<li><a href="#">&laquo;</a></li>
							<li><a href="#">Позавера</a></li>
							<li><a href="#">Вчера</a></li>
							<li><a href="#"><input type="date" name="date_gain" value="{{ date('Y-m-d') }}" class="form-control"></a></li>
							<li><a href="#">Завтра</a></li>
							<li><a href="#">Послезавтра</a></li>
							<li><a href="#">&raquo;</a></li>
						</ul>
						<input type="range" class="form-control" min="0" max="31" value="{{ date('d') }}" />	
					</div>
					<div class="panel-body">
						Panel content
					</div>
					<div class="panel-footer">Panel footer</div>
				</div>
			</div>
			<div class="tab-pane" id="expenses">
				<div class="panel panel-success">
					<div class="panel-heading">Доходы</div>
					<div class="panel-body">
						Panel content
					</div>
					<div class="panel-footer">Panel footer</div>
				</div>			
			</div>
			<div class="tab-pane" id="move">
				<div class="panel panel-info">
					<div class="panel-heading">Движение</div>
					<div class="panel-body">
						Panel content
					</div>
					<div class="panel-footer">Panel footer</div>
				</div>			
			</div>
		</div>
		
	</div>
	
	<div class="col-md-3 col-xs-12 col-md-pull-9" style="background: #BCA;"> <!-- left column -->
		@include('layouts.leftmenu')
	</div>
	
</div>
@endsection


