@extends('layouts.user')

@section('inner-banner')

<div class="row-fluid inner-top">
	<div class="span6 inner-content">
		<h2>{{ $page_title}}</h2>
		<p>So glad you're here. I'm sure you know what to do.</p>
	</div>
	<img src="{{ URL::to('/') }}/img/inner-folder.png">
</div>

@section('content')
<div class="span12 dcontent">
	{{ Form::open( array('route'=>'register_post')) }}
	<div class="control-group">
		<label class="control-label" for="first_name">First Name :</label>
		<div class="controls">
			{{ Form::text('first_name',Input::get('first_name'),array('class'=>'input-xxlarge')) }}
		</div>
	</div>
	<div class="control-group">
	<label class="control-label" for="last_name">Last Name :</label>
		<div class="controls">
			{{ Form::text('last_name',Input::get('last_name'),array('class'=>'input-xxlarge')) }}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="rto">Email * :</label>
		<div class="controls">
			{{ Form::text('email',Input::get('email'),array('class'=>'input-xxlarge')) }}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="password">Password * :</label>
		<div class="controls">
			<input type="password" name="password" class="input-xxlarge" id="password" value="{{ Input::old('password') }}" placeholder="">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="password">Confirm Password *:</label>
		<div class="controls">
			<input type="password" name="password_confirmation" class="input-xxlarge" id="password_confirmation" value="{{ Input::old('password_confirmation') }}" placeholder="">
		</div>
	</div>
	<button type="submit" class="btn btn-large">Register</button>
	{{ Form::close() }}
</div>
@stop