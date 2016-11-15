@extends('layouts.app')

@section('content')
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#date_mainform').change(function() {
			window.location.href = "{{ Route('home') }}/"+moment(this.value).format("DD/MM/YYYY");
		});	
		
		var mySelect = $('#first-disabled2');
		$('#special').on('click', function () {
			mySelect.find('option:selected').prop('disabled', true);
			mySelect.selectpicker('refresh');
		});
		
		$('#expenses_cat_id, #expenses_summa, #expenses_prim').click(function() {
			alert(111);
		});
	
	});	

	function SlipRange(newVal) {
		var d = moment($("#date_mainform").val());
		var url = "{{ Route('home') }}" + "/";
		
		$("#date_mainform").val(d.set('date', parseInt(newVal)).format("YYYY-MM-DD"));
		$("#dayBeforeYesterday").text(d.set('date', parseInt(newVal)-2).format("DD.MM.YYYY"));
		$("#yesterday").text(d.set('date', parseInt(newVal)-1).format("DD.MM.YYYY"));
		$("#tomorrow").text(d.set('date', parseInt(newVal)+1).format("DD.MM.YYYY"));
		$("#dayAfterTomorrow").text(d.set('date', parseInt(newVal)+2).format("DD.MM.YYYY"));

		//$("#myspan").text( url );
		$("#firstDayUrl").attr("href", url+d.set('date', parseInt(newVal)-3).format("DD/MM/YYYY"));
		$("#dayBeforeYesterday").attr("href", url+d.set('date', parseInt(newVal)-2).format("DD/MM/YYYY"));
		$("#yesterday").attr("href", url+d.set('date', parseInt(newVal)-1).format("DD/MM/YYYY"));
		$("#tomorrow").attr("href", url+d.set('date', parseInt(newVal)+1).format("DD/MM/YYYY"));
		$("#dayAfterTomorrow").attr("href", url+d.set('date', parseInt(newVal)+2).format("DD/MM/YYYY"));
		$("#lastDayUrl").attr("href", url+d.set('date', parseInt(newVal)+3).format("DD/MM/YYYY"));
		
		return false;
		
	}
	
	function onMouseUpRande() {
		$('#date_mainform').change();
	}
	
</script>

<div class="row">
	<div class="col-md-9 col-xs-12 col-md-push-3"> <!-- content -->
		<div class="row text-center">	<!-- filter -->
			<div class="col-md-12">
				<ul class="pagination" style="margin: 0px;">
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['firstDay']['uriFormat']}}" id="firstDayUrl">&laquo;</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['dayBeforeYesterday']['uriFormat']}}" id="dayBeforeYesterday">
						{{ $date_list_for_uri['dayBeforeYesterday']['niceFormat'] }}
					</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['yesterday']['uriFormat']}}" id="yesterday">
						{{ $date_list_for_uri['yesterday']['niceFormat'] }}
					</a></li>
					<li><a href="#"><input type="date" name="date_mainform" id="date_mainform" value="{{ $date_mainform }}" class="form-control"></a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['tomorrow']['uriFormat']}}" id="tomorrow">
						{{ $date_list_for_uri['tomorrow']['niceFormat'] }}
					</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['dayAfterTomorrow']['uriFormat']}}" id="dayAfterTomorrow">
						{{ $date_list_for_uri['dayAfterTomorrow']['niceFormat'] }}
					</a></li>
					<li><a href="{{ Route('home') }}/{{$date_list_for_uri['lastDay']['uriFormat']}}" id="lastDayUrl">&raquo;</a></li>
				</ul>
				<input type="range" class="form-control" 
				min="1" max="<?php echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('y')); //Кол-во дней в месяце ?>" 
				value="<?php echo explode("-", $date_mainform)[2]; //текущий день ?>" oninput="SlipRange(this.value)" 
				onchange="SlipRange(this.value)" onMouseUp="onMouseUpRande()"/>
			</div>
		</div>
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#expenses" data-toggle="tab">{{ trans('home.expenses') }}</a></li>
			<li><a href="#gain" data-toggle="tab">{{ trans('home.gain') }}</a></li>			
			<li><a href="#moving" data-toggle="tab">{{ trans('home.moving') }}</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" style="padding-top: 10px; padding-bottom: 10px;" id="expenses">	<!-- TAB 1 -->
				<form role="form" method="POST" action="{{ Route('homePost') }}" id="expenses_form" name="expenses_form">
					<input type="hidden" name="expenses_date_mainform" id="expenses_date_mainform" value="{{ $date_mainform }}">
					<div class="row" id="expenses_row_1">
						<div class="col-md-4">
							<div class="form-group">
								<select class="selectpicker form-control" data-live-search="true" id="expenses_cat_id" name="expenses_cat_id" title="{{ trans('home.where spent?') }}">
								@if (isset($cat_expenses))
									@foreach ($cat_expenses as $cat)
										@if (isset($cat['parent']))	{{-- есть ли родитель (если нет, то путаница какая-то произошла) --}}
											<option value="{{ $cat['parent']->id }}">{{ $cat['parent']->name }}</option>
										@endif
										@if (isset($cat['childs']))	{{-- если есть дети, то выводим --}}
											@foreach ($cat['childs'] as $child)
												<option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>
											@endforeach
										@endif
									@endforeach
								@else
									<option value="0">{{ trans('home.category not found') }}</option>
								@endif
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<input type="text" class="form-control" id="expenses_summa" name="expenses_summa" placeholder="0">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" id="expenses_prim" name="expenses_prim" placeholder="Примечание">
							</div>
						</div>
						<div class="col-md-1 text-center">
							<button type="button" class="btn btn-default" id="expenses_btn_del" name="expenses_btn_del"><span class="glyphicon glyphicon-remove"></span> </button>
						</div>
					</div>
					
					<div class="row" id="expenses_row_2">
						<div class="col-md-4">
							<div class="form-group">
								<select class="selectpicker form-control" data-live-search="true" id="expenses_cat_id" name="expenses_cat_id" title="{{ trans('home.where spent?') }}">
								@if (isset($cat_expenses))
									@foreach ($cat_expenses as $cat)
										@if (isset($cat['parent']))	{{-- есть ли родитель (если нет, то путаница какая-то произошла) --}}
											<option value="{{ $cat['parent']->id }}">{{ $cat['parent']->name }}</option>
										@endif
										@if (isset($cat['childs']))	{{-- если есть дети, то выводим --}}
											@foreach ($cat['childs'] as $child)
												<option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>
											@endforeach
										@endif
									@endforeach
								@else
									<option value="0">{{ trans('home.category not found') }}</option>
								@endif
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<input type="text" class="form-control" id="expenses_summa" name="expenses_summa" placeholder="0">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" id="expenses_prim" name="expenses_prim" placeholder="Примечание">
							</div>
						</div>
						<div class="col-md-1 text-center">
							<button type="button" class="btn btn-default" id="expenses_btn_del" name="expenses_btn_del"><span class="glyphicon glyphicon-remove"></span> </button>
						</div>
					</div>					
				
					<div class="row" id="expenses_row_footer">
						<div class="col-md-12">
							<div class="form-group">
								<textarea class="form-control" rows="2" id="expenses_note" name="expenses_note" placeholder="{{ trans('home.comment to the day') }}">{{ old('categoryDescription') }}</textarea>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane" id="gain"> <!-- TAB 2 -->
				<div class="panel panel-danger">
					<div class="panel-heading">
						Gain
					</div>
					<div class="panel-body">
						Panel content
					</div>
					<div class="panel-footer">Panel footer</div>
				</div>
			</div>			
			<div class="tab-pane" id="moving"> <!-- TAB 3 -->
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
	
	<div class="col-md-3 col-xs-12 col-md-pull-9"> <!-- left column -->
		@include('layouts.leftmenu')
	</div>
	
</div>

@endsection


