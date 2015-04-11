<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width">
	<link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>

	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/style.css') }}
	{{ HTML::style('css/user.css') }}
</head>
<body>
<div class='container'>
	@if(Sentry::check())
		<p class="userlink" > {{ link_to_route('myaccount', 'My Account') }}</p>| Welcome !
	@endif
</div>
	@yield('inner-banner')
	@yield('content')
<div class='container'>
	<div class="row-fluid footer">
		<div class="span8 footer-menu">
			<ul>
				<li>{{ link_to_route('/', 'Contact') }}</li>
				<li>{{ link_to_route('about', 'About Us') }}</li>
				<li>{{ link_to_route('login', 'Login') }}</a></li>
				<li>{{ link_to_route('register', 'Register') }}</a></li>
			</ul>
		</div>
		<div class="span4 copyright">
			<h4>Foldagram is patent pending</h4>
		<p>&copy;Copyright All Encompassing Productions llc, 2012</p>
		</div>
	</div>
</div>
</body>
</html>