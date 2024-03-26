@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="card floating-header bg-it-primary">
	<div class="card-header header-center header-md-start rounded border-0 bg-it-primary">
		<h1 class="card-title d-flex flex-row position-relative h3">
			<span class="m-auto">Reset Password</span>

			{{-- LOCK/UNLOCK VIEW --}}
			<span id="lock-view" class="position-absolute posabs-vertical-middle posabs-outerright fs-5 ms-auto my-auto unlocked">
				{{-- UNLOCK ICON --}}
				<button class="remove-button-style p-3 fa-lock-open" type="button" data-bs-title="Toggle to lock view" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="it-tooltip" aria-title="Toggle to lock view">
					<i class="fas fa-lock-open"></i>
				</button>

				{{-- LOCK ICON --}}
				<button class="remove-button-style p-3 fa-lock"  type="button" data-bs-title="Toggle to unlock view" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="it-tooltip" aria-title="Toggle to unlock view">
					<i class="fas fa-lock"></i>
				</button>
			</span>
		</h1>
	</div>

	<form action="@{{ route('change-password.update', [$token]) }}" method="POST" class="card-body">
		@csrf

		<div class="row">
			{{-- NOTE --}}
			<div class="col-12">
				<p class="card-text">
					Want to test how strong your password is?
					Check it in <a href="https://nordpass.com/secure-password/">Nord VPN's password tester</a>
					or in <a href="https://www.uic.edu/apps/strong-password/">University of Illinois' password tester</a>.
				</p>
			</div>

			{{-- PASSWORD --}}
			<div class="col-12 my-2 form-group">
				<label class="form-label d-none" for="password">Password</label>

				<div class="input-group">
					<input id="password" type="password" name="password" class="form-control border-end-0 border-style-solid border-secondary" placeholder="Password" required>
					<button type="button" class="btn btn-it-white border-start-0 border border-style-solid border-secondary toggle-show-password" data-target="#password">
						<i class="fas fa-eye d-none show" title="Show"></i>
						<i class="fas fa-eye-slash hide" title="Hide"></i>
					</button>
				</div>

				<span class="small text-danger">{{ $errors->first('password') }}</span>
			</div>

			{{-- CONFIRM PASSWORD --}}
			<div class="col-12 my-2 form-group">
				<label class="form-label d-none" for="password_confirmation">Confirm Password</label>

				<div class="input-group">
					<input id="password_confirmation" type="password" name="password_confirmation" class="form-control border-end-0 border-style-solid border-secondary" placeholder="Confirm Password" required>
					<button type="button" class="btn btn-it-white border-start-0 border border-style-solid border-secondary toggle-show-password" data-target="#password_confirmation">
						<i class="fas fa-eye d-none show" title="Show"></i>
						<i class="fas fa-eye-slash hide" title="Hide"></i>
					</button>
				</div>

				<span class="small text-danger">{{ $errors->first('password_confirmation') }}</span>
			</div>
		</div>

		<div class="form-group text-center">
			<button type="submit" class="btn btn-primary" data-action="update">Submit</button>
		</div>
	</form>
</div>
@endsection

@push('scripts')
{{-- PASSWORD TIPS --}}
@include('includes.password-tips')
@endpush
