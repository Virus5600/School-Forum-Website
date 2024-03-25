<!DOCTYPE html>
<html lang="en">
	<head>
		{{-- META DATA --}}
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Language" content="en-US" />

		{{-- SITE META --}}
		<meta name="type" content="website">
		<meta name="title" content="{{ $webName }}">
		<meta name="description" content="{{ $webDesc }}">
		<meta name="image" content="{{ asset('uploads/settings/meta-banner.png') }}">
		<meta name="keywords" content="{{ env('APP_KEYW') }}">
		<meta name="application-name" content="{{ $webName }}">

		{{-- TWITTER META --}}
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="{{ $webName }}">
		<meta name="twitter:description" content="{{ $webDesc }}">
		<meta name="twitter:image" content="{{ asset('uploads/settings/meta-banner.png') }}">

		{{-- OG META --}}
		<meta name="og:url" content="{{ Request::url() }}">
		<meta name="og:type" content="website">
		<meta name="og:title" content="{{ $webName }}">
		<meta name="og:description" content="{{ $webDesc }}">
		<meta name="og:image" content="{{ asset('uploads/settings/meta-banner.png') }}">

		{{-- FAVICON --}}
		<link rel="icon" href="{{ $webLogo }}">
		<link rel="shortcut icon" href="{{ $webLogo }}">
		<link rel="apple-touch-icon" href="{{ $webLogo }}">
		<link rel="mask-icon" href="{{ $webLogo }}">

		{{-- COMMON LIBS --}}
		<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ mix('css/util/custom-scrollbar.css') }}">
		<script type="text/javascript" src="{{ mix('js/app.js') }}" nonce="{{ csp_nonce() }}"></script>

		{{-- CUSTOM STYLES --}}
		<link rel="stylesheet" type="text/css" href="{{ mix('views/layouts/public/public.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}">
		<script type="text/javascript" src="{{ mix('views/login/login.js') }}" nonce="{{ csp_nonce() }}"></script>

		{{-- TITLE --}}
		<title>{{ $webName }} | Login</title>
	</head>

	<body>
		{{-- NOSCRIPT --}}
		@include('includes.noscript')

		<div class="d-flex flex-column min-vh-100 js-only position-relative">
			<div class="d-flex flex-row flex-grow-1 h-100 bg-it-primary">
				{{-- BACKGROUND LEFT --}}
				<div class="w-100 w-md-75 unblur" id="left-hemisphere" style="--bg-img: url('{{ asset("uploads/settings/login-default.png") }}');">
				</div>

				{{-- BACKGROUND RIGHT --}}
				<div class="d-none d-md-block bg-it-quaternary" id="right-hemisphere">
				</div>
			</div>

			{{-- LOGIN CARD --}}
			<div class="w-75 w-md-50 w-lg-25 position-absolute posabs-center posabs-md-vertical-middle posabs-md-outerright m-md-auto login-card">
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
			</div>

			{{-- TITLE --}}
			{{-- <img src="{{ asset("uploads/settings/default.png") }}" class="img w-50 position-absolute posabs-outerleft posabs-outerbottom d-none d-md-block" draggable="false"> --}}
		</div>

		{{-- SCRIPTS --}}
		<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
		@include('includes.swal-flash')

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
	</body>
</html>
