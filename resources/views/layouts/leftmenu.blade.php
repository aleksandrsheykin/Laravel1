<div class="row">
	<div class="col-md-12">
		<div class="list-group">
            @if (!isset($selected_menu))
				<?php $selected_menu = ''; ?>
            @endif		
			<a href="{{ route('home') }}" class="list-group-item @if ($selected_menu == 'home') active @endif">{{ trans('home.main') }}</a>
			<a href="{{ route('categories') }}" class="list-group-item @if ($selected_menu == 'categories') active @endif">{{ trans('home.categories') }}
				@if (isset($category_count)) 
					<span class="badge badge-info">{{ $category_count }}</span>
				@endif
			</a>
			<a href="{{ route('accounts') }}" class="list-group-item @if ($selected_menu == 'accounts') active @endif">{{ trans('home.cash accounts') }}
				@if (isset($cash_count)) 
					<span class="badge badge-info">{{ $cash_count }}</span>
				@endif
			</a>
			<a href="{{ route('cheaper') }}" class="list-group-item @if ($selected_menu == 'cheaper') active @endif">{{ trans('home.know where it is cheaper') }}</a>
			<a href="{{ route('question') }}" class="list-group-item @if ($selected_menu == 'question') active @endif">{{ trans('home.ask a question') }}</a>
		</div>
	</div>
</div>