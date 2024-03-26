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
		<title>{{ $webName }} | @yield('title')</title>
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
			<main class="w-75 w-md-50 w-lg-25 position-absolute posabs-center posabs-md-vertical-middle posabs-md-outerright m-md-auto login-card" id="content">
				@yield('content')
			</main>

			{{-- TITLE --}}
			{{-- <img src="{{ asset("uploads/settings/default.png") }}" class="img w-50 position-absolute posabs-outerleft posabs-outerbottom d-none d-md-block" draggable="false"> --}}
		</div>

		{{-- SCRIPTS --}}
		<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
		@include('includes.swal-flash')
		@stack('scripts')
	</body>
</html>
