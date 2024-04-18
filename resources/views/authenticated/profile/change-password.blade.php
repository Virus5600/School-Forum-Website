@extends('layouts.public', ['noCarousel' => true, 'additionalBodyClasses' => 'no-blur'])

@section('title', 'Profile - Change Password')

@section('content')
{{-- Change Password --}}
<section class="d-flex flex-column justify-content-center align-items-center">
	<form action="{{ route('profile.change-password.update') }}" method="POST" class="card floating-header floating-footer border-0 w-100 w-md-75 w-lg-50" autocomplete="off">
		{{-- Header --}}
		<h2 class="card-header header-center header-md-start border-0 rounded bg-it-primary text-white">Change Password</h2>

		{{-- Actual Form --}}
		<div class="card-body bg-it-primary text-white rounded">
			@csrf
			@method('PATCH')

			{{-- Current Password --}}
			<div class="form-group my-2">
				<label class="form-label required-after" style="--required-color: var(--bs-it-tertiary)" for="current-password">Password</label>

				<div class="input-group">
					<input id="current-password" type="password" name="current_password" class="form-control bg-it-quaternary border-end-0 border-style-none" placeholder="Current Password" required>
					<button type="button" class="btn btn-it-quaternary border-start-0 border-style-none toggle-show-password" data-target="#current-password">
						<i class="fas fa-eye d-none text-dark show" title="Show"></i>
						<i class="fas fa-eye-slash text-dark hide" title="Hide"></i>
					</button>
				</div>

				<x-forms.validation-error field="current_password" />
			</div>

			{{-- New Password --}}
			<div class="form-group my-2">
				<label class="form-label required-after" style="--required-color: var(--bs-it-tertiary)" for="password">New Password</label>

				<div class="input-group">
					<input id="password" type="password" name="password" class="form-control bg-it-quaternary border-end-0 border-style-none" placeholder="New Password" required>
					<button type="button" class="btn btn-it-quaternary border-start-0 border-style-none toggle-show-password" data-target="#password">
						<i class="fas fa-eye d-none text-dark show" title="Show"></i>
						<i class="fas fa-eye-slash text-dark hide" title="Hide"></i>
					</button>
				</div>

				<x-forms.validation-error field="password" />
			</div>

			{{-- Confirm Password --}}
			<div class="form-group my-2">
				<label class="form-label required-after" style="--required-color: var(--bs-it-tertiary)" for="password_confirmation">Confirm New Password</label>

				<div class="input-group">
					<input id="password_confirmation" type="password" name="password_confirmation" class="form-control bg-it-quaternary border-end-0 border-style-none" placeholder="Confirm New Password" required>
					<button type="button" class="btn btn-it-quaternary border-start-0 border-style-none toggle-show-password" data-target="#password_confirmation">
						<i class="fas fa-eye d-none text-dark show" title="Show"></i>
						<i class="fas fa-eye-slash text-dark hide" title="Hide"></i>
					</button>
				</div>

				<x-forms.validation-error field="password_confirmation" />
			</div>
		</div>

		{{-- Footer --}}
		<div class="card-footer footer-center footer-md-end border-0 rounded bg-it-primary text-white">
			<div class="hstack gap-3">
				{{-- Update Button --}}
				<button type="submit" class="btn btn-it-secondary text-white" data-dos-action="update">Submit</button>

				{{-- Reset Button --}}
				<button type="reset" class="btn btn-dark text-white" data-dos-action="reset">Reset</button>

				{{-- Cancel Button --}}
				<a href="{{ route('profile.index') }}" class="btn btn-secondary text-white">Go Back</a>
			</div>
		</div>
	</form>
</section>
@endsection

@push('css')
<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}">
@endpush

@push('scripts')
{{-- PASSWORD TIPS --}}
@include('includes.password-tips', ['alertAdditionalClass' => 'mt-md-7'])

<script type="text/javascript" src="{{ mix('views/login/login.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
@endpush
