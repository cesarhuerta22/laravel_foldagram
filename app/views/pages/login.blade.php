@extends("layouts.user")

@section('inner-banner')

<div class="row-fluid inner-top">
	<div class="span6 inner-content">
		<h2>{{ $page_title}}</h2>
		<p>So glad you're here. I'm sure you know what to do.</p>
	</div>
	<img src="{{ URL::to('/') }}/img/inner-folder.png">
</div>

@section('content')

<div class="content-container">
	{{ Form::open( array('route'=>'login_post')) }}
	<div class="container">
		<div class="content">
			<div class="box login">
				<fieldset class="boxBody">
					<label>Email</label>
					{{ Form::email('email',Input::old('email'),array('placeholder'=>'Enter your E-mail')) }}
					<label>Password</label>
					{{ Form::password('password', array('placeholder' => 'Enter your Password')) }}
				</fieldset>
				<input type="submit" class="btn btn-large btn-primary" value="Login" tabindex="3">
			</div>
		</div>
	</div>
	{{ Form::close() }}
</div>

@stop