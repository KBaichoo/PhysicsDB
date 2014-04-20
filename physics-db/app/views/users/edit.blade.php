@extends('master')

@section('content')
{{ Form::model($user,['method' => 'PATCH', 'route' => 'users.update'], $user->id) }}	



	<!-- email -->
	{{ Form::label('email', 'Email') }}
	{{ Form::email('email') }}			


	{{ Form::label('level', 'Level of user(1 = teacher, 2 = admin, 3 = superadmin)') }}
	{{ Form::selectRange('level',1,3) }}

	{{ Form::submit('Update Account!') }}

{{ Form::close() }}
@stop