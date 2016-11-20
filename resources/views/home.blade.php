@extends('layouts.app')

@section('content')
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#date_mainform').change(function() {
			window.location.href = "{{ Route('home') }}/"+moment(this.value).format("DD/MM/YYYY");
		});	
		
		$(document).on('click', '#expensesSumma, #expensesPrim', function(e) {	//добавляем строки в форму
			var emptyRow = 0;
			$('[id = expensesSumma]').each(function(i, e) {	//считаем пустые строки (пустой считается та строка, у которой не заполненна сумма)
				if ($(e).val() == "") {
					emptyRow++;
				}
			});
			
			if (emptyRow < 2) {	//добавляем строку, т.к всего одна осталась свободная
				addRow('expenses');
			}
		});
		
		$(document).on('click', '#expensesBtnDel', function(e) {	//delete row
			var rowNum = parseInt($(this).attr('name').replace('expensesBtnDel_', ''));
			$('#expensesRow_'+rowNum).remove();
			SetNumRowsAfterDelete(rowNum);
		});
		
		$(document).on('keyup', '#expensesSumma', function(e) {	//only numeric, ., ,
			$(this).val($(this).val().replace(/[^\d,.]*/g, '')
									.replace(/([,.])[,.]+/g, '$1')
									.replace(/^[^\d]*(\d+([.,]\d{0,5})?).*$/g, '$1'));
		});
	
	});
	
	function SlipRange(newVal) 
	{
		var d = moment($("#date_mainform").val());
		var url = "{{ Route('home') }}" + "/";
		
		$("#date_mainform").val(d.set('date', parseInt(newVal)).format("YYYY-MM-DD"));
		$("#dayBeforeYesterday").text(d.set('date', parseInt(newVal)-2).format("DD.MM.YYYY"));
		$("#yesterday").text(d.set('date', parseInt(newVal)-1).format("DD.MM.YYYY"));
		$("#tomorrow").text(d.set('date', parseInt(newVal)+1).format("DD.MM.YYYY"));
		$("#dayAfterTomorrow").text(d.set('date', parseInt(newVal)+2).format("DD.MM.YYYY"));

		$("#firstDayUrl").attr("href", url+d.set('date', parseInt(newVal)-3).format("DD/MM/YYYY"));
		$("#dayBeforeYesterday").attr("href", url+d.set('date', parseInt(newVal)-2).format("DD/MM/YYYY"));
		$("#yesterday").attr("href", url+d.set('date', parseInt(newVal)-1).format("DD/MM/YYYY"));
		$("#tomorrow").attr("href", url+d.set('date', parseInt(newVal)+1).format("DD/MM/YYYY"));
		$("#dayAfterTomorrow").attr("href", url+d.set('date', parseInt(newVal)+2).format("DD/MM/YYYY"));
		$("#lastDayUrl").attr("href", url+d.set('date', parseInt(newVal)+3).format("DD/MM/YYYY"));
		
		return false;
	}
	
	function onMouseUpRande() 
	{
		$('#date_mainform').change();
	}

	function addRow(prefix) 
	{
		if (prefix == '') { prefix = 'expenses'; }
		
		var maxRows = 50;
		var countRows = $('div[id*=expensesRow_]').length;
		if (countRows >= maxRows) {
			return false;
		}
		
		var numRow = countRows + 1;

		var row = '<div class="row" id="'+prefix+'Row_'+numRow+'">	\
		<input type="hidden" id="'+prefix+'OldId" name="'+prefix+'OldId_'+numRow+'" value="">	\
		<div class="col-md-4"><div class="form-group">';

		//create a select with options on expenses or gain
		row += '<select class="selectpicker form-control" data-live-search="true" id="'+prefix+'CatId" name="'+prefix+'CatId_'+numRow+'" title="{{ trans("home.where spent?") }}">';
		var optionsExpenses = '';
		@if (isset($cat_expenses))
			@foreach ($cat_expenses as $cat)	
				@if (isset($cat["parent"]))	{{-- есть ли родитель (если нет, то путаница какая-то произошла) --}}	
					optionsExpenses += '<option value="{{ $cat["parent"]->id }}">{{ $cat["parent"]->name }}</option>';
				@endif	
				@if (isset($cat["childs"]))	{{-- если есть дети, то выводим --}}	
					@foreach ($cat["childs"] as $child)	
						optionsExpenses += '<option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>';
					@endforeach	
				@endif	
			@endforeach
		@else
			optionsExpenses += '<option value="0">{{ trans("home.category not found") }}</option>';
		@endif

		var optionsGain = '';
		@if (isset($cat_gain))
			@foreach ($cat_gain as $cat)	
				@if (isset($cat["parent"]))	{{-- есть ли родитель (если нет, то путаница какая-то произошла) --}}	
					optionsGain += '<option value="{{ $cat["parent"]->id }}">{{ $cat["parent"]->name }}</option>';
				@endif	
				@if (isset($cat["childs"]))	{{-- если есть дети, то выводим --}}	
					@foreach ($cat["childs"] as $child)	
						optionsGain += '<option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>';
					@endforeach	
				@endif	
			@endforeach
		@else
			optionsGain += '<option value="0">{{ trans("home.category not found") }}</option>';
		@endif
		
		if (prefix = 'expenses') {
			row += optionsExpenses;
		} else if (prefix = 'gain') {
			row += optionsGain;
		}
		
		row += '</select>';
		
		row += '</div></div>	\
		<div class="col-md-3"><div class="form-group">	\
			<input type="text" class="form-control" id="'+prefix+'Summa" name="'+prefix+'Summa_'+numRow+'" placeholder="{{ trans("home.total") }}">	\
		</div></div>	\
		<div class="col-md-4"><div class="form-group">	\
			<input type="text" class="form-control" id="'+prefix+'Prim" name="'+prefix+'Prim_'+numRow+'" placeholder="{{ trans("home.comment") }}">	\
		</div></div>	\
		<div class="col-md-1 text-center" style="padding-bottom: 10px;">	\
			<button type="button" class="btn btn-danger" id="'+prefix+'BtnDel" name="'+prefix+'BtnDel_'+numRow+'" title="{{ trans("home.delete") }}"><span class="glyphicon glyphicon-remove"></span> </button>	\
		</div></div>';

		$('#'+prefix+'RowFooter').before(row);
		$('#'+prefix+'RowCount').val(numRow);
		
		$('.selectpicker').selectpicker('refresh');	// refresh select's (add search in new select)
		
		if (countRows >= maxRows-1) {
			if (prefix = 'expenses') {
				ShowErrorModal('{{ trans("home.reached the maximum") }}', '{{ trans("home.wow! You spend a lot. You can not make more than") }} '+maxRows+' {{ trans("home.entries per day.") }}');
			} else if (prefix = 'gain') {
				ShowErrorModal('{{ trans("home.reached the maximum") }}', '{{ trans("home.wow! You earn a lot. You can not make more than") }} '+maxRows+' {{ trans("home.entries per day.") }}');
			}
			return false;
		}
	}
	
	function SetNumRowsAfterDelete(rowNum)	//сдвигаем все строки после удаленной (строки должны быть пронумерованны по порядку)
	{
		var countRows = $('div[id*=expensesRow_]').length;
		var i;	
		for (i = parseInt(rowNum)+1; i <= countRows+1; i++) {
			$('#expensesRow_'+i).attr('id', 'expensesRow_'+(i-1));
			$('[name=expensesOldId_'+i+']').attr('name', 'expensesOldId_'+(i-1));
			$('[name=expensesCatId_'+i+']').attr('name', 'expensesCatId_'+(i-1));
			$('[name=expensesSumma_'+i+']').attr('name', 'expensesSumma_'+(i-1));
			$('[name=expensesPrim_'+i+']').attr('name', 'expensesPrim_'+(i-1));
			$('[name=expensesBtnDel_'+i+']').attr('name', 'expensesBtnDel_'+(i-1));
		}
		$('#expensesRowCount').val(countRows);
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
		
@if (isset($data_expenses))
	@foreach ($data_expenses as $d_e)
		{{ $d_e['summa'] }}
	@endforeach
@endif

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" style="padding-top: 10px; padding-bottom: 10px;" id="expenses">	<!-- TAB 1 -->
				<form role="form" method="POST" action="{{ Route('homePost') }}" id="expenses_form" name="expenses_form">
					{{ csrf_field() }}
					<input type="hidden" name="expensesDateMainform" id="expensesDateMainform" value="{{ $date_mainform }}">
					<input type="hidden" name="expensesRowCount" id="expensesRowCount" value="2">
					
					<div class="row" id="expensesRow_1" name="expensesRow">
						<input type="hidden" id="expensesOldId" name="expensesOldId_1" value="">
						<div class="col-md-4">
							<div class="form-group" id="divWithSelect_1">
								<select class="selectpicker form-control" data-live-search="true" id="expensesCatId" name="expensesCatId_1" title="{{ trans('home.where spent?') }}">
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
								<input type="text" class="form-control" id="expensesSumma" name="expensesSumma_1" placeholder="{{ trans('home.total') }}">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" id="expensesPrim" name="expensesPrim_1" placeholder="{{ trans('home.comment') }}">
							</div>
						</div>
						<div class="col-md-1 text-center" style="padding-bottom: 10px;"></div>
					</div>
					
					<div class="row" id="expensesRow_2" name="expensesRow">
						<input type="hidden" id="expensesOldId" name="expensesOldId_2" value="">
						<div class="col-md-4">
							<div class="form-group" id="divWithSelect_2">
								<select class="selectpicker form-control" data-live-search="true" id="expensesCatId" name="expensesCatId_2" title="{{ trans('home.where spent?') }}">
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
								<input type="text" class="form-control" id="expensesSumma" name="expensesSumma_2" placeholder="{{ trans('home.total') }}">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" id="expensesPrim" name="expensesPrim_2" placeholder="{{ trans('home.comment') }}">
							</div>
						</div>
						<div class="col-md-1 text-center" style="padding-bottom: 10px;">
							<button type="button" class="btn btn-danger" id="expensesBtnDel" name="expensesBtnDel_2" title="{{ trans('home.delete') }}"><span class="glyphicon glyphicon-remove"></span> </button>
						</div>
					</div>					
				
					<div class="row" id="expensesRowFooter">
						<div class="col-md-10">
							<div class="form-group">
								<textarea class="form-control" rows="2" id="expensesComment" name="expensesComment" placeholder="{{ trans('home.comment to the day') }}">{{ old('categoryDescription') }}</textarea>
							</div>
						</div>
						<div class="col-md-2">
							<button style="width: 100%;" type="submit" class="btn btn-success" title="{{ trans('home.save') }}" name="submitExpenses" value="submitExpenses"><span class="glyphicon glyphicon-floppy-saved"></span> {{ trans('home.save') }}</button>
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


