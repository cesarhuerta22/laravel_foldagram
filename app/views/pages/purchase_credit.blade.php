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
<div class="row price">
	<div class="span6 well price_content">
		<h3>Current Price</h3>
		<p>Foldagrams can either be purchased one at a time, or with
		credits. When you pay for credits in advance, you receive a discount.
		Don't worry, you don't have to use them all at once! The prices shown
		already include postage.</p>

		@if($credit)
			<ul>
			@foreach($credit as $value)
				<li>{{ $value->rfrom ." - ". $value->rto ." Foldagrams - $".$value->price." each" }}</li>
			@endforeach
			</ul>
		@endif
	</div>

	<div class="span6 well price_content">
	{{ Form::open(array('route' => 'addtocredit',)) }}
	<h3>Purchase Credit</h3>
	{{ Form::label('', 'Foldagrams:') }}
	{{ Form::label('qty', 'Quantity ') }}
	{{ Form::text('qty',Input::old('qty'),['class'=>'text']) }}
	{{ Form::label('price', 'Per Foldagram') }}
	{{ Form::text('price',Input::old('price'), ['class'=>'text']) }}
	{{ Form::submit('Add to Cart',array("class"=>"btn-large ")) }}
	{{ Form::close() }}
	</div>

</div>
<script type="text/javascript">
	$(function () {
		$.post(
			base_url+'price/',{ 
				qty:$('#qty').val()
			}, 
			function(data) {
			$('#price').val(data);
		});
	});
</script>

@stop