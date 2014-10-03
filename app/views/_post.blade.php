<div class="bs-callout bs-callout-info">
    <h4 class="post-title">{{$post['title']}}</h4>
    <p class="post-description">{{$post['description']}}</p>
    <p class="post-email">Email: <b>{{$post['email']}}</b></p>
     @if ($canApprove)
        <p class="post-email">Status: <b>{{Post::getStatus($post['confirmed'])}}</b></p>
     @endif
    @if ($canEdit || $canApprove)
    <div class="post-buttons">
        @if ($canApprove)
            @if($post['confirmed'] != Post::POST_STATUS_APPROVED)
            <a href="{{URL::to('domoderate', array('action' => 'approve', 'id' => $post['id']))}}" class="btn btn-primary">Approve</a>
            @endif
            @if($post['confirmed'] != Post::POST_STATUS_REJECTED)
            <a href="{{URL::to('domoderate', array('action' => 'reject', 'id' => $post['id']))}}" class="btn btn-primary">Reject</a>
            @endif
        @endif
    </div>
    @endif
</div>