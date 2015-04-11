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
<div>
	<div class='container'>
		{{ Form::open( array( 'url' => '/')) }}
		<label style="display: inline-block">Order Status :</label>&nbsp;
		{{ Form::select('status',Config::get('status'), null, ['class' => 'input-medium']) }}
		<input type="submit" name="submit" value="Search" class="btn btn-info" style="display: inline-block">
		{{ Form::close() }}
	</div>
	<div>
		<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th>Order No.</th>
				<th>Email</th>
				<th>Message</th>
				<th>Picture</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		@foreach($orders as $value)
			<tr>
				<td>{{ $value->id }}</td>
				<td>{{ $value->email }}</td>
				<td>{{ $value->message }}</td>
				<td>@if($value->image!="")
						@if(File::exists('public/img/thumbnails/'.$value->image))
							{{ HTML::image('img/thumbnails/'.$value->image, "Foldagram Image", ['width'=>'100px']) }}
						@else
							{{ HTML::image ('img/thumbnails/100x100.png') }}
						@endif
					@endif
				</td>
				<td> <?php $status = Config::get('status'); ?>
					{{ Form::text('status',$value->status,['class' => 'text']) }}
				</td>
				<td>
					<a href="{{ URL::to('admin/order/recipients/'.$value->id) }}" class="btn">
						<i class="icon-pencil"></i> View Recipient's
					</a>&nbsp;
					<a href="{{ URL::to('admin/order/details/'.$value->id) }}" class="btn btn-info">
						<i class="icon-pencil"></i> Order Details
					</a>&nbsp;
					<a href="{{ URL::to('admin/order/update/'.$value->id) }}" class="btn btn-success">
						<i class="icon-pencil"></i> Update Status
					</a>&nbsp;
					<a href="{{ URL::to('admin/order/delete/'.$value->id) }}" class="btn btn-danger">
						<i class="icon-remove-sign"></i> Delete
					</a>
				</td>
			</tr>
		@endforeach
		</tbody>
		</table>
	</div>
</div>
@stop