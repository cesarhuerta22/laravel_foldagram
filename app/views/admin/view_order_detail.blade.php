@extends('layouts.admin')
@section('content')

<div class='container'>
<h3>Foldagram Order Details </h3>
<table class="table table-striped table-bordered table-condensed-table">
	<tbody>
	@if(!empty($order_detail))
		<tr>
			<th>Transection ID:</th>
			<td>{{ $order_detail->transection_id }} </td>
		</tr>
		<tr>
			<th>Quantity :</th>
			<td>{{ $order_detail->qty }} </td>
		</tr>
		<tr>
			<th>Price :</th>
			<td>{{ $order_detail->price }} </td>
		</tr>
		<tr>
		<th>Total :</th>
		<td>{{ ($order_detail->qty * $order_detail->price) }} </td>
		</tr>
		<tr>
		<th>Email :</th>
		<td>{{ $order_detail->email }} </td>
		</tr>
		<tr>
		<th>Full Name :</th>
		<td>{{ $order_detail->users->first_name }} {{ $order_detail->users->last_name }} </td>
		</tr>
	@endif
	</tbody>
</table>
</div>

@stop