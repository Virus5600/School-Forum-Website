@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="card floating-header bg-it-primary text-white border-white">
	<div class="card-header header-center header-md-start border border-white rounded bg-it-primary">
		<h1 class="card-title d-flex flex-row position-relative h3">
			<span class="m-auto">Reset Password</span>

			@include('includes.auth.lock-view', ['absolutePosition' => false])
		</h1>
	</div>

	<div class="card-body" id="form">
		<form action="{{ route('change-password.update', [$token]) }}" method="POST">
			@csrf

			<div class="row">
				{{-- NOTE --}}
				<div class="col-12">
					<p class="card-text">
						Want to test how strong your password is?
						Check it in <a href="https://nordpass.com/secure-password/" class="link-body-emphasis" data-bs-theme="dark">Nord VPN's password tester</a>
						or in <a href="https://www.uic.edu/apps/strong-password/" class="link-body-emphasis" data-bs-theme="dark">University of Illinois' password tester</a>.
					</p>
				</div>

				{{-- PASSWORD --}}
				<div class="col-12 my-2 form-group">
					<label class="form-label d-none" for="password">Password</label>

					<div class="input-group">
						<input id="password" type="password" name="password" class="form-control bg-it-quaternary border-end-0 border-style-none" placeholder="Password" required>
						<button type="button" class="btn btn-it-quaternary border-start-0 border-style-none toggle-show-password" data-target="#password">
							<i class="fas fa-eye d-none text-dark show" title="Show"></i>
							<i class="fas fa-eye-slash text-dark hide" title="Hide"></i>
						</button>
					</div>

					<span class="small text-danger">{{ $errors->first('password') }}</span>
				</div>

				{{-- CONFIRM PASSWORD --}}
				<div class="col-12 my-2 form-group">
					<label class="form-label d-none" for="password_confirmation">Confirm Password</label>

					<div class="input-group">
						<input id="password_confirmation" type="password" name="password_confirmation" class="form-control bg-it-quaternary border-end-0 border-style-none" placeholder="Confirm Password" required>
						<button type="button" class="btn btn-it-quaternary border-start-0 border-style-none toggle-show-password" data-target="#password_confirmation">
							<i class="fas fa-eye d-none text-dark show" title="Show"></i>
							<i class="fas fa-eye-slash text-dark hide" title="Hide"></i>
						</button>
					</div>

					<span class="small text-danger">{{ $errors->first('password_confirmation') }}</span>
				</div>
			</div>

			<div class="form-group text-center">
				<button type="submit" class="btn btn-it-secondary" data-action="update">Submit</button>
			</div>
		</form>
	</div>
</div>
@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}">
@endpush

@push('scripts')
	{{-- PASSWORD TIPS --}}
	@include('includes.password-tips')
	<script type="text/javascript" src="{{ mix('views/login/login.js') }}"></script>
@endpush
