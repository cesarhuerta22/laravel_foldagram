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
<table class="table table-striped table-bordered table-condensed table">
<thead>
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Status</th>
		<th>User Type</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
@if(!empty($users))
	@foreach($users as $user)
	<tr>
		<td>{{ $user->first_name }}</td>
		<td>{{ $user->last_name }}</td>
		<td>{{ $user->email }}</td>
		<td>
			@if($user->activated=="1")
				<span class="label label-success">Active</span>
			@endif
			@if($user->activated=="0")
				<span class="label label-important">Block</span>
			@endif
		</td>
		<td>
			<a href="{{ URL::to('admin/user/edit/'.$user->id)}}" class="btn">
				<i class="icon-pencil"></i> Edit
			</a>
			<a href="{{ URL::to('admin/user/delete/'.$user->id) }}" class="btn btn-danger">
				<i class="icon-remove-sign"></i>Delete
			</a>
			@if($user->activated=="1")
			<a href="{{ URL::to('admin/user/block/'.$user->id) }}" class="btn btn-danger">
				<i class="icon-ban-circle"></i>Block
			</a>
			@endif
			@if($user->activated=="0")
			<a href="{{ URL::to('admin/user/active/'.$user->id) }}" class="btn btn-success">
				<i class="icon-ok-circle"></i>Active
			</a>
			@endif
			<a href="{{ URL::to('usercreditorder/'.$user->id) }}" class="btn btn-info">
				<i class="icon-list"></i>Purchase Credit Order
			</a>
		</td>
	</tr>
	@endforeach
@else
<tr>
	<td colspan="6" class="sr-align-center">No Users Found</td>
</tr>
@endif
</tbody>
</table>
<p> {{ $pager }} <p>
@stop