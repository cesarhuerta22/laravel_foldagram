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
<div class="container">
	{{ Form::open(array('route' => 'user_credit_post', 'method' => 'post')) }}
	<div class="control-group">
		<label class="control-label" for="rfrom">Select User :</label>
		<div class="controls">
			{{ Form::select('user_email', array(' '=>"-- Select User --")+$users, Input::old('user_email')) }}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="rto">Credit :</label>
		<div class="controls">
			<input type="text" name="rto" id="rto" value="{{ Input::old('rto') }}" placeholder="">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="price">Price :</label>
		<div class="controls">
			<input type="text" name="price" id="price" value="{{ Input::old('price') }}" placeholder="">
		</div>
	</div>
	<div class="form-actions">
	<button type="submit" class="btn btn-primary">Save</button>
	{{ link_to_route('user', 'Cancel', '',array('class'=>'btn')) }}
	</div>
	{{ Form::close() }}
</div>
@stop