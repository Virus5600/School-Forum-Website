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
		<link rel="stylesheet" type="text/css" href="{{ mix('views/layouts/auth/auth.css') }}">
		@stack('css')

		{{-- TITLE --}}
		<title>{{ $webName }} | @yield('title')</title>

		@php($noBlur = isset($noBlur) ? $noBlur : false)
	</head>

	<body class="{{ $noBlur ? 'no-blur' : '' }} custom-scrollbar apply-to-all">
		{{-- NOSCRIPT --}}
		@include('includes.noscript')

		<div class="d-flex flex-column min-vh-100 js-only position-relative">
			<div class="d-flex flex-row flex-grow-1 h-100 bg-it-primary">
				{{-- BACKGROUND LEFT --}}
				<div class="z-0 w-100 w-md-75 unblur" id="left-hemisphere" style="--bg-img: url('{{ asset("uploads/settings/login-default.png") }}');">
				</div>

				{{-- BACKGROUND RIGHT --}}
				<div class="z-1 d-none d-md-block" id="right-hemisphere">
				</div>
			</div>

			{{-- AUTH CARD --}}
			<main class="z-2 max-vh-75 {{ isset($formWidth) ? $formWidth : "w-75 w-md-50 w-lg-25" }} position-absolute {{ isset($position) ? $position : "posabs-center posabs-md-vertical-middle posabs-md-outerright" }} m-md-auto {{ isset($additionalClasses) ? $additionalClasses : "" }}" id="content">
				@yield('content')
			</main>

			{{-- TITLE --}}
			{{-- <img src="{{ asset("uploads/settings/default.png") }}" class="img w-50 position-absolute posabs-outerleft posabs-outerbottom d-none d-md-block" draggable="false"> --}}
		</div>

		{{-- SCRIPTS --}}
		@if (!$noBlur)
		<script type="text/javascript" src="{{ mix('views/layouts/auth/auth.js') }}" nonce="{{ csp_nonce() }}"></script>
		@endif
		<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}" nonce="{{ csp_nonce() }}"></script>
		<script type="text/javascript" nonce="{{ csp_nonce() }}" data-to-remove>
			$(() => {
				{{ $noBlur ? 'window.noBlur = true;' : '' }}
				$(`[data-to-remove]`).remove();
			});
		</script>
		@include('includes.swal-flash')
		@stack('scripts')
	</body>
</html>
