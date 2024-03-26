@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form class="card bg-it-primary" method="POST" action="{{ route("authenticate") }}" enctype="multipart/form-data" autocomplete="off">
	<div class="card-header text-center">
		<h1 class="card-title d-flex flex-row position-relative h3">
			<span class="m-auto">LOGIN</span>

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

	<div class="card-body">
		<div id="login-form">
			{{-- Some Image --}}
			<div class="text-center d-block d-md-none mb-3">
				<img src="{{ asset("uploads/settings/default.png") }}" class="img img-fluid w-25 bg-white rounded-circle p-1" draggable="false">
			</div>

			{{-- Actual Form --}}
			<div class="border border-it-secondary rounded p-3">
				@csrf

				{{-- USERNAME --}}
				<div class="form-group">
					<label for="username" class="form-label">Username</label>
					<input id="username" type="text" name="username" class="form-control bg-it-quaternary border-style-none" value="{{ old('username') }}" required>
				</div>

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
					<a href="#" class="w-100 text-center">Forgot Password.</a>
				</div>
			</div>

			<div class="d-flex flex-column justify-content-center">
				<a href="{{ route('register') }}" id="redirectToRegister" class="text-center">
					Don't have an account yet?
				</a>
			</div>

			{{-- CURSOR ANIMATION --}}
			<span class="cursor-anim"></span>
		</div>
	</div>

	<div class="card-footer d-flex justify-content-center gap-3">
		<button type="submit" data-action="login" class="btn btn-it-secondary">Login</button>
		<a href="{{ route('home') }}" class="btn btn-dark">Go Back</a>
	</div>
</form>
@endsection

@push('scripts')
	@if (Session::has('flash_error') || Session::has('flash_info'))
	<script type="text/javascript" id="for-removal" nonce="{{ csp_nonce() }}">
		$(document).ready(() => {
			setTimeout(() => {
				$(`#lock-view`)[0].click();
				$(`#for-removal`)[0].remove();
			}, 1000);
		});
	</script>
	@endif
@endpush
