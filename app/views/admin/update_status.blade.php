@extends('layouts.admin')

@section('content')
<div class="container">
	{{ Form::open(array('route' =>'order_update_post')); }}
	<input type="hidden" name="id" value="{{ $foldagram->id }}">
	<div class="control-group">
		<label class="control-label" for="rfrom">Message :</label>
		<div class="controls">
			{{ $foldagram->message }}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="rto">Picture :</label>
		<div class="controls">
			@if($foldagram->image!="")
				{{ HTML::image('img/thumbnails/'.$foldagram->image,"Foldagram Image",array('width'=>'100px')) }}
			@endif
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="rto">Current Status :</label>
		<div class="controls">
			<?php $status = Config::get('status'); ?>
			{{ Form::text('status',$foldagram->status,['class' => 'text']) }}
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="rto">Change Status :</label>
		<div class="controls">
			{{ Form::select('status',Config::get('status'), null, ['class' => 'input-medium']) }}
		</div>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		{{ link_to_route('orders', 'Cancel', '',array('class'=>'btn')) }}
	</div>
	{{ Form::close() }}
</div>
@stop