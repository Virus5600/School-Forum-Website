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
		<meta name="image" content="{{ asset('uploads/settings/meta-banner.jpeg') }}">
		<meta name="keywords" content="{{ env('APP_KEYW') }}">
		<meta name="application-name" content="{{ $webName }}">

		{{-- TWITTER META --}}
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="{{ $webName }}">
		<meta name="twitter:description" content="{{ $webDesc }}">
		<meta name="twitter:image" content="{{ asset('uploads/settings/meta-banner.jpeg') }}">

		{{-- OG META --}}
		<meta name="og:url" content="{{ Request::url() }}">
		<meta name="og:type" content="website">
		<meta name="og:title" content="{{ $webName }}">
		<meta name="og:description" content="{{ $webDesc }}">
		<meta name="og:image" content="{{ asset('uploads/settings/meta-banner.jpeg') }}">

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
		<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
		<script type="text/javascript" src="{{ mix('views/login/login.js') }}" nonce="{{ csp_nonce() }}"></script>

		{{-- TITLE --}}
		<title>Reset Password - {{ $webName }}</title>
	</head>

	<body class="bg-light">
		{{-- NOSCRIPT --}}
		@include('includes.noscript')

		<div class="d-flex flex-column min-vh-100 js-only">
			<main class="content d-flex flex-column flex-grow-1 my-3 my-lg-5" id="content">
				<div class="container-fluid d-flex flex-column flex-grow-1">

					{{-- CHANGE PASSWORD FORM START --}}
					<div class="card floating-header w-100 w-sm-75 w-md-50 w-lg-25 m-auto rounded border border-secondary border-style-solid">
						<h4 class="card-header header-center header-md-start rounded border border-secondary bg-white">Reset Password</h4>

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
										<button type="button" class="btn btn-it-white border-start-0 border border-style-solid border-secondary" id="toggle-show-password" data-target="#password">
											<i class="fas fa-eye d-none" id="show" title="Show"></i>
											<i class="fas fa-eye-slash" id="hide" title="Hide"></i>
										</button>
									</div>

									<span class="small text-danger">{{ $errors->first('password') }}</span>
								</div>

								{{-- CONFIRM PASSWORD --}}
								<div class="col-12 my-2 form-group">
									<label class="form-label d-none" for="password_confirmation">Confirm Password</label>

									<div class="input-group">
										<input id="password_confirmation" type="password" name="password_confirmation" class="form-control border-end-0 border-style-solid border-secondary" placeholder="Confirm Password" required>
										<button type="button" class="btn btn-it-white border-start-0 border border-style-solid border-secondary" id="toggle-show-password" data-target="#password_confirmation">
											<i class="fas fa-eye d-none" id="show" title="Show"></i>
											<i class="fas fa-eye-slash" id="hide" title="Hide"></i>
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
					{{-- CHANGE PASSWORD FORM END --}}

				</div>
			</main>
		</div>

		{{-- PASSWORD TIPS --}}
		@include('includes.password-tips')

		{{-- SCRIPTS --}}
		<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
		@include('includes.swal-flash')
		@stack('scripts')
	</body>
</html>
