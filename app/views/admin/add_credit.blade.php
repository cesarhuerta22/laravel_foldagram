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
	{{ Form::open( array ( 'route' => 'add_credit_post')) }}
	<div class="control-group">
		<label class="control-label" for="rfrom">Form Qty :</label>
		<div class="controls">
			<input type="text" name="rfrom" id="rfrom" value="{{ Input::old('rfrom') }}" placeholder="Form Qty">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="rto">To Qty :</label>
		<div class="controls">
			<input type="text" name="rto" id="rto" value="{{ Input::old('rto') }}" placeholder="To Qty">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputEmail">Price :</label>
		<div class="controls">
			<input type="text" name="price" id="price" value="{{ Input::old('price') }}" placeholder="Price">
		</div>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		{{ link_to_route('credit', 'Cancel', '', array('class'=>'btn')) }}
	</div>
	{{ Form::close() }}
</div>