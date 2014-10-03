<h2>New post {{$post['title']}} is created</h2>
<p>{{$post['description']}}</p>
<p>Email: {{$post['email']}}</p>

<a href="{{URL::to('domoderate', array('action' => 'approve', 'id' => $post['id']))}}" target="_blank">Approve</a> or
<a href="{{URL::to('domoderate', array('action' => 'reject', 'id' => $post['id']))}}" target="_blank">Reject</a>