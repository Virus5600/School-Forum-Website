@extends('layouts.auth', ['noBlur' => true])

@section('title', 'Verify Email')

@section('content')
<form class="card floating-header floating-footer bg-it-primary text-white border rounded border-it-secondary m-lg-1" method="POST" action="{{ route("verification.verify") }}" enctype="multipart/form-data">
	<h1 class="z-3 card-header card-title h3 bg-it-primary border rounded border-it-secondary">Verify Your Email</h1>

	{{-- ACTUAL FORM --}}
	<div class="z-0 card-body max-vh-75 overflow-auto scroll-bg-transparent" style="--custom-scrollbar-color: rgb(248 249 250); --custom-scrollbar-hover: rgb(173 181 189); --custom-scrollbar-active: rgb(222 226 230);">
		@csrf

		<div class="form-group">
			<label for="code" class="form-label">Verification Code</label>
			<input type="text" id="code" name="code" class="form-control required-after" value="{{ old('code') }}" required>

			@error('code')
			<span class="small badge text-bg-danger w-100 fs-2xs">{{ $message }}</span>
			@enderror
		</div>
	</div>

	{{-- FORM BUTTONS --}}
	<div class="z-3 card-footer bg-it-primary text-white border rounded border-it-secondary footer-center">
		<div class="hstack gap-3">
			{{-- SUBMIT BUTTON --}}
			<button type="submit" class="btn btn-it-secondary text-white">Submit</button>

			{{-- RE-SEND BUTTON --}}
			<button type="button" class="btn btn-it-secondary text-white" id="resend-verification-email">Resend Code</button>
		</div>
	</div>
</form>
@endsection

@push('meta')
	<meta name="token" content="{{ csrf_token() }}">
	<meta name="bearer" content="{{ session()->get('bearer') }}">
	<meta name="resend-email-url" content="{{ route('verification.resend') }}">
	<meta name="login-url" content="{{ route('login') }}">
@endpush

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}" nonce="{{ csp_nonce() }}">
	<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}" nonce="{{ csp_nonce() }}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{{ mix('views/login/login.js') }}" nonce="{{ csp_nonce() }}"></script>
	<script type="text/javascript" src="{{ mix('views/authenticated/verification/verification.js') }}" nonce="{{ csp_nonce() }}" defer></script>
	<script type="text/javascript" src="{{ mix('js/util/swal-flash.js') }}" nonce="{{ csp_nonce() }}" defer></script>
@endpush
