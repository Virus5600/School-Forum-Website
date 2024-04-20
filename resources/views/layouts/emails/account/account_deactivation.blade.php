@extends('layouts.emails.layout')

@section('title')
Your Account Has Been Deactivated.
@endsection

@section('content')
{{-- TODO: Build the view for this email template --}}
<p>
	@if ($recipient == $args['email'])
	Your account has been deactivated and your profile has been removed from the site.
	@else
	An account for <code>{{ $args['email'] }}</code> has been
	deactivated and the profile has been removed from the site.
	@endif
</p>

@if (isset($args['reason']))
	<p>Reason for deactivation:</p>
	<blockquote>{{ $args['reason'] }}</blockquote>
@endif

<p>
	To reactivate the said account, simply log back in with your email and password.
	This will reactivate your account and restore your profile, allowing you to continue
	using the site as normal.
</p>

<p>
	Please note that you will need to re-verify your email address and complete any additional
	steps required to reactivate your account. If you have any issues or need assistance with
	reactivating your account, please contact us and we will be happy to help.
</p>

<p>
	<b>
		This wasn't you? <a href="{{ route('contact-us') }}">Contact us</a> immediately
		so we can investigate and resolve the issue.
	</b>
</p>
@endsection
