@extends('layouts.main')

@section('content')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@if(Session::has('error'))
<p class="alert {{ Session::get('alert-class', 'alert-error') }}">{{ Session::get('message') }}</p>
@endif

<h1>{{$title}}</h1>
@foreach ($posts as $post)
    @include('..._post', array(
        'post' => $post,
        'canEdit' => Auth::user()->hasRole(Role::ROLE_ADMIN) || (Auth::user()->hasRole(Role::ROLE_MANAGER) && Auth::user()->id == $post->user_id),
        'canApprove' => $canApprove,
    ))
@endforeach
@stop