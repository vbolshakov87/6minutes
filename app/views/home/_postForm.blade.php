<ul>
	@foreach($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
</ul>

<div class="form-group">
	{{ Form::label('title', 'title', array('class'=>'col-sm-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('title', !empty($post['title']) ? $post['title'] : null, array('class'=>'form-control')) }}
	</div>
</div>
<div class="form-group">
    {{ Form::label('title', 'description', array('class'=>'col-sm-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::textarea('description', !empty($post['description']) ? $post['description'] : null, array('class'=>'form-control')) }}
	</div>
</div>
<div class="form-group">
    {{ Form::label('email', 'email', array('class'=>'col-sm-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::email('email', !empty($post['email']) ? $post['email'] : null, array('class'=>'form-control')) }}
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		{{ Form::submit(!empty($post) ? 'Update' : 'Create', array('class'=>'btn btn-default'))}}
	</div>
</div>