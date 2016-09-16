<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'homebu.ru') }} administration</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
	<link href="/css/dashboard.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin">{{ config('app.name', 'Homebu.ru') }} administration</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="{{ Route('settings') }}">Settings</a></li>
            <li><a href="{{ Route('index') }}">Index</a></li>
            <li>
				<a href="{{ url('/logout') }}"
					onclick="event.preventDefault();
							 document.getElementById('logout-form').submit();">
					Logout
				</a>		
				<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
					{{ csrf_field() }}
				</form>				
			</li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            @if (!isset($selected_menu))
                <?php $selected_menu = 'overview'; ?>
            @endif
            <li @if ($selected_menu == 'Overview') class="active" @endif><a href="{{ route('admin') }}">Overview</a></li>
			<li @if ($selected_menu == 'Users') class="active" @endif><a href="{{ route('adminUsers') }}">Users</a></li>
            <li @if ($selected_menu == 'Categories') class="active" @endif><a href="{{ route('adminCategories') }}">Start Categories</a></li>
            <li @if ($selected_menu == 'Heroes') class="active" @endif><a href="#">Heroes</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li @if ($selected_menu == 'Messages') class="active" @endif><a href="">Messages</a></li>
            <li @if ($selected_menu == 'overvie') class="active" @endif><a href="">Nav item again</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li @if ($selected_menu == 'overvie') class="active" @endif><a href="">Nav item again</a></li>
            <li @if ($selected_menu == 'overvie') class="active" @endif><a href="">One more nav</a></li>
            <li @if ($selected_menu == 'overvie') class="active" @endif><a href="">Another nav item</a></li>
          </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">{{ $selected_menu or 'selected_menu is empty' }}</h1>
            
            @yield('content')
            
        </div>
        
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
    <script src="/js/docs.min.js"></script>	
</body>
</html>
