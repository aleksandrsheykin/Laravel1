@extends('layouts.app')

@section('content')
<script>
	function setdate(date) {
		//
	}
</script>
<div class="row">
	<div class="col-md-9 col-xs-12 col-md-push-3"> <!-- content -->
		<div class="row text-center">	<!-- filter -->
			<div class="col-md-12">
				<ul class="pagination" style="margin: 0px;">
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['firstDay']['uriFormat']}}">&laquo;</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['dayBeforeYesterday']['uriFormat']}}">Позавера</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['yesterday']['uriFormat']}}">Вчера</a></li>
					<li><a href="{{ Route('home') }}/"><input type="date" name="date_gain" value="{{ $date_mainform }}" class="form-control"></a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['tomorrow']['uriFormat']}}">Завтра</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['dayAfterTomorrow']['uriFormat']}}">Послезавтра</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['lastDay']['uriFormat']}}">&raquo;</a></li>
				</ul>
				<input type="range" class="form-control" min="0" max="31" value="{{ date('d') }}" />
			</div>
		</div>
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a class="bg-warning" href="#gain" data-toggle="tab">Расходы</a></li>
			<li class="bg-success"><a href="#expenses" data-toggle="tab">Доходы</a></li>
			<li><a href="#move" class="bg-info" data-toggle="tab">Перемещения</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="gain">
				<div class="panel panel-warning">
					<div class="panel-heading">
						Gain
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


