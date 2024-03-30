@extends('layouts.emails.layout')

@section('title')
New Verification Code
@endsection

@section('content')
<p>
	A new verification code has been generated for your account.
	This code will be used for the first time you log in. And will
	only be valid for a single day.
</p>

<p>
	Please do not share this code with anyone else. If you did not
	request this code, please contact the administrator immediately.
</p>

<p>Here's your new code:</p>

<code style="font-size: large;">
	<span style="font-family: Arial;">Code:</span> {{ $args['code'] }}
</code>
@endsection
