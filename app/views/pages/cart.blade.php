@extends('layouts.user')

@section('inner-banner')

<div class="row-fluid inner-top">
	<div class="span6 inner-content">
		<h2>{{ $page_title}}</h2>
		<p>So glad you're here. I'm sure you know what to do.</p>
	</div>
	<img src="{{ URL::to('/') }}/img/inner-folder.png">
</div>
<br><br><br>

@section('content')
<div class="well">
<table class="table table-hover table-striped table-bordered">
<thead>
	<tr>
		<th width="40%">Name</th>
		<th width="20">Recipient</th>
		<th width="8%">Qty.</th>
		<th width="12%">Price</th>
		<th width="12%">Total</th>
	</tr>
</thead>
<tbody>
	@forelse ($cart_contents as $item)
	<tr>
		<td>  {{ $item->id }}
		@if( $item->user_id != "" )
			<strong>{{ $item->users->first_name }} {{ $item->users->last_name }}</strong>
		@else
			<strong> No hay usuario</strong>
		@endif
			<span class="pull-right">
				<a href="{{ URL::route('/') }}" rel="tooltip" title="Remove the product" class="btn btn-mini btn-danger"><i class="icon icon-white icon-remove"></i></a>
			</span>
		</td>
		@if( $item->transection_id != "" )
		<td>{{ $item->foldagrams->id }}</td>
		@else
		<td>No hay recipiente</td>
		@endif
		<td>{{ $item->qty }}</td>
		<td>{{ money_format('%10.2n',$item->price) }}</td>
		<?php $total = $item->qty * $item->price; ?>
		<td>{{ money_format('%10.2n',$total) }}</td>
	</tr>
	@empty
	<tr>
		<td colspan="6">Your shopping cart is empty.</td>
	</tr>
	@endforelse
</tbody>
</table>

<div class="well">
	<h3> Billing information </h3>
	<label for="fullname"> Full Name * </label>
	<input class="required input-xxlarge" type="text" name="fullname" id="fullname">
	<label for="country"> Country * </label>
	<input class="required input-xlarge" type="text" name="country" id="country">
	<label for="address_one">Address 1 *</label>
	<input class="required input-xxlarge" type="text" name="address_one" id="address_one">
	<label for="address_two"> Address 2 </label>
	<input class="input-xxlarge" type="text" name="address_two" id="address_two">
	<label for="city"> City * </label>
	<input class="required input-xlarge" type="text" name="city" id="city">
	<label for="state"> State * </label>
	<input class="required input-xlarge" type="text" name="state" id="state">
	<label for="zipcode"> Zip code * </label>
	<input class="required input-xlarge" type="text" name="zipcode" id="zipcode">
	<input type="hidden" name="action" value="foldagram_checkout">
</div>

<div class="well credit_card">
	<h3>Payment</h3>
	<div class="payment-errorme alert alert-error" style="display:none">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
<div class="payment-errors"></div>
</div>
	{{ Form::label('credit_owner', 'Card Owner *') }}
	{{ Form::text('credit_owner', Input::old('credit_owner'),
		array('class'=>'required','placeholder'=>'Enter credit card woner.')) }}

	{{ Form::label('credit_card', 'Card Number *') }}
	{{ Form::text('credit_number', Input::old('credit_number'),
		array('class'=>'card-number required','placeholder'=>'Enter credit card number.')) }}

	{{ Form::label('expiration', 'Expiration *') }}
	{{ Form::selectMonth('month', Input::old('month'),['class'=>'field']) }}
	{{ Form::selectYear('year', 1900, 2015, Input::old('year'),['class'=>'span2 required card-expiry-year']) }}

	{{ Form::label('code', 'Security code *') }}
	{{ Form::text('code', Input::old('code'),
		array('class'=>'card-cvc required','placeholder'=>'Enter security code.')) }}
</div>