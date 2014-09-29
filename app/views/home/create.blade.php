@extends('...layouts.main')

@section('content')
{{ Form::open(array('url'=>'create', 'class'=>'form-horizontal', 'role'=>'form')) }}
<div class="bs-example bs-examples-short">
	<h2 class="form-signup-heading">Create new post</h2>
	@include('home._postForm', array('post' => array()))
</div>
{{ Form::close() }}
@stop