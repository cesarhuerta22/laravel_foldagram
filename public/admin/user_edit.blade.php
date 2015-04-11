@extends('layouts.admin')

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
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">My Profile</a></li>
		<li><a href="#tab2" data-toggle="tab">Change Password</a></li>
		<li><a href="#tab3" data-toggle="tab">My Orders</a></li>
		<li><a href="{{ URL::route('logout') }}">LogOut</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
				{{ Form::open( array('route' => 'profile_post')); }}
			<div class="control-group">
				<label class="control-label" for="first_name">First Name :</label>
				<div class="controls">
					<input type="text" name="first_name" id="first_name" value="{{ $user['first_name'] }}" placeholder="">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="last_name">Last Name :</label>
				<div class="controls">
					<input type="text" name="last_name" id="last_name" value="{{ $user['last_name'] }}" placeholder="">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="rto">Email :</label>
				<div class="controls">
					<input type="text" name="email" id="email" value="{{ $user['email'] }}" placeholder="">
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>

@stop