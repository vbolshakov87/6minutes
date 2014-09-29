@extends('layouts.main')

@section('content')
{{ Form::open(array('url'=>'login', 'class'=>'form-horizontal', 'role'=>'form')) }}
<div class="bs-example bs-examples-short">
	<h2 class="form-signup-heading">Sign in</h2>
	<ul>
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>


	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-10">
			{{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Login')) }}
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
		<div class="col-sm-10">
			{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			{{ Form::submit('Sign in', array('class'=>'btn btn-default'))}}
		</div>
	</div>
</div>
{{ Form::close() }}
@stop

