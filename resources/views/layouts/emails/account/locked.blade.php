@extends('layouts.emails.layout')

@section('title')
An attempt to access you account has been made!
@endsection

@section('content')
<p style="text-indent: 1rem;">Your account was locked after 5 failed attempts of logging in. Please create a new password for your account.</p>
<p>Click this link or copy and open it on another tab to <span title="This may be a good time to update your password to a stronger one since someone is trying to access it.">change your password.</span></p>

<p>
	<a href="{{ route("change-password.edit", [$args['token']]) }}">{{ route("change-password.edit", [$args['token']]) }}</a>
</p>

@php
$ip = $user->locked_by == '::1' ? '' : $user->locked_by;

if (config('app.env') == 'local' || config('app.env') == 'testing') {
	$arrContextOptions=array(
		"ssl"=>array(
			"verify_peer" => false,
			"verify_peer_name" => false,
		),
	);

	$contents = file_get_contents(
		"https://ip-api.io/json/{$ip}",
		false,
		stream_context_create($arrContextOptions)
	);
}
else {
	$contents = file_get_contents("https://ip-api.io/json/{$ip}");
}

$ipData = json_decode($contents);
@endphp

<label for="data">Your account is being accessed:</label>
<div style="background-color: lightgray; padding: 1rem;">
	<code id="data">
		IP: {{ $ipData ? $ipData->ip : 'IP Not Valid' }}<br>
		Country: {{ $ipData ? $ipData->country_name : 'IP Not Valid' }}<br>
		Region: {{ $ipData ? $ipData->region_name : 'IP Not Valid' }}<br>
		City: {{ $ipData ? $ipData->city : 'IP Not Valid' }}<br>
		ISP: {{ $ipData ? $ipData->organisation : 'IP Not Valid' }}<br>
	</code>
</div>
@endsection
