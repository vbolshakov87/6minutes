@extends('layouts.main')

@section('content')
@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<h1>{{$title}}</h1>
@foreach ($posts as $post)
    @include('..._post', array(
        'post' => $post,
        'canEdit' => Auth::check() && Auth::user()->hasRole(Role::ROLE_ADMIN),
        'canApprove' => $canApprove,
    ))
@endforeach
@stop