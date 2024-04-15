@extends('layouts.emails.layout')

@section('title')
Your Email Has Been Updated.
@endsection

@section('content')
<p>
	Your email has been updated. If you did not request this change, please contact us immediately.
</p>

<p>
	Your new email is: <code>{{ $args['email'] }}</code>
</p>

<p>
	To access your account, go to the <a href="{{ route('login') }}">login</a> page and enter your credentials.
</p>

<code style="font-size: large;">
	<span style="font-family: Arial;">Code:</span> {{ $args['code'] }}
</code>

<p>
	The code provided will serve as your verification code to verify your new email address.
</p>
@endsection
