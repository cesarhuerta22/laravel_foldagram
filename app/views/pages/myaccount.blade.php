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
	<div class="tabbable">
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
		<div class="tab-pane" id="tab2">
			{{ Form::open( array('route' => 'changepass_post')); }}
			<div class="control-group">
				<label class="control-label" for="old_password">Old Password:</label>
				<div class="controls">
					<input type="password" name="old_password" id="old_password" value="" placeholder="">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password">New Password :</label>
				<div class="controls">
					<input type="password" name="password" id="password" value="{{ Input::old('password') }}" placeholder="">
				</div>
			</div>
			<div class="control-group">
			<label class="control-label" for="password">Confirm New Password :</label>
				<div class="controls">
					<input type="password" name="password_confirmation" id="password_confirmation" value="{{ Input::old('password_confirmation') }}" placeholder="">
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
			{{ Form::close() }}
		</div>
		<div class="tab-pane" id="tab3">
			<h3>My Order</h3>
			<table class="table table-striped table-bordered table-condensed ">
			<thead>
				<tr>
					<th>Message</th>
					<th>Picture</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@if(!empty($orders->results))
					@foreach($orders->results as $value)
					<tr>
						<td>{{ $value->message }}</td>
						<td>
						@if($value->image!="")
							@if(File::exists(path('public').'img/thumbnails/'.$value->image))
								{{ HTML::image('img/thumbnails/'.$value->image, "Foldagram Image", array('width'=>'100px')) }}
							@endif
						@endif
						</td>
						<td> <?php $status = Config::get('application.status'); ?>
						@if($value->status=='1')
							{{ Label::important($status[$value->status]) }}
						@elseif ($value->status=='2')
							{{ Label::success($status[$value->status]) }}
						@elseif ($value->status=='3')
							{{ Label::normal($status[$value->status]) }}
						@elseif ($value->status=='4')
							{{ Label::warning($status[$value->status]) }}
						@elseif ($value->status=='5')
							{{ Label::success($status[$value->status]) }}
						@elseif ($value->status=='6')
							{{ Label::success($status[$value->status]) }}
						@elseif ($value->status=='7')
							{{ Label::success($status[$value->status]) }}
						@endif
						</td>
					</tr>
					@endforeach
				@else
				<tr>
					<td colspan="3" class="sr-align-center" style="text-align: center">There is any order</td>
				</tr>
				@endif
			</tbody>
			</table>
		</div>
	</div>
</div>
@stop