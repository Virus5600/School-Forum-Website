@extends('layouts.auth', ['noBlur' => true, 'position' => 'posabs-center', 'formWidth' => 'w-100 w-sm-75 w-md-50'])

@section('title', 'Confirm Password')

@section('content')
<form class="card floating-header floating-footer bg-it-primary text-white border rounded border-it-secondary m-2" method="POST" action="{{ route("password.confirm.submit") }}" enctype="multipart/form-data">
	<h1 class="z-3 card-header card-title h3 bg-it-primary border rounded border-it-secondary header-center header-md-start">
		Confirm Password
	</h1>

	<div class="card-body max-vh-75 overflow-auto scroll-bg-transparents" style="--custom-scrollbar-color: rgb(248 249 250); --custom-scrollbar-hover: rgb(173 181 189); --custom-scrollbar-active: rgb(222 226 230);">
		<p class="card-text">
			You are about to perform a sensitive action that requires your password to confirm your identity.
			Please enter your password to continue.
		</p>

		<p class="card-text">
			Once you have confirmed your password, you will be able to proceed with the action you requested.
			Please note that this confirmation will expire after a certain period of time for security reasons.
		</p>

		{{-- Actual Form --}}
		<div id="form">
			<div class="border border-it-secondary rounded p-3">
				@csrf

				{{-- PASSWORD --}}
				<div class="form-group">
					<label for="password" class="form-label">Password</label>

					<div class="input-group">
						<input id="password" type="password" name="password" class="form-control bg-it-quaternary border-end-0 border-style-none" required>
						<button type="button" class="btn btn-it-quaternary border-start-0 border-style-none" id="toggle-show-password" aria-label="Show Password" data-target="#password">
							<i id="show" class="fas fa-eye d-none text-dark" title="Show"></i>
							<i id="hide" class="fas fa-eye-slash text-dark" title="Hide"></i>
						</button>
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="form-label">Confirm Password</label>

					<div class="input-group">
						<input id="confirm-password" type="password" name="password_confirmation" class="form-control bg-it-quaternary border-end-0 border-style-none" required>
						<button type="button" class="btn btn-it-quaternary border-start-0 border-style-none" id="toggle-show-password" aria-label="Show Password" data-target="#confirm-password">
							<i id="show" class="fas fa-eye d-none text-dark" title="Show"></i>
							<i id="hide" class="fas fa-eye-slash text-dark" title="Hide"></i>
						</button>
					</div>
				</div>

				<div class="form-group">
					<a href="{{ route('forgot-password') }}" id="redirectToForgotPassword" class="w-100 text-center link-body-emphasis" data-bs-theme="dark">
						Forgot Password.
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="card-footer hstack gap-3 bg-it-primary border rounded border-it-secondary footer-center footer-md-end">
		<button type="submit" data-dos-action="submit" class="btn btn-it-secondary text-white">Confirm</button>
		<a href="{{ session()->get('before-confirm-password') }}" class="btn btn-dark">Go Back</a>
	</div>
</form>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}" nonce="{{ csp_nonce() }}">
<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}" nonce="{{ csp_nonce() }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ mix('views/login/login.js') }}" nonce="{{ csp_nonce() }}"></script>
@endpush
