<h2>Hello {{$post['email']}}</h2>
<p>Your post "{{$post['title']}}" is <b>
@if($post['confirmed'] == Post::POST_STATUS_APPROVED)
    approved
@else
    rejected
@endif
</b>
</p>