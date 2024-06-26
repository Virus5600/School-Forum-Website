<!DOCTYPE html>
<html lang="en">
	<head>
		{{-- META DATA --}}
		<meta http-equiv="Content-Type" content="text/html">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Language" content="en-US" />
		@stack('meta')

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
		<meta property="og:url" name="og:url" content="{{ Request::url() }}">
		<meta property="og:type" name="og:type" content="website">
		<meta property="og:title" name="og:title" content="{{ $webName }}">
		<meta property="og:description" name="og:description" content="{{ $webDesc }}">
		<meta property="og:image" name="og:image" content="{{ asset('uploads/settings/meta-banner.png') }}">

		{{-- FAVICON --}}
		<link rel="icon" href="{{ $webLogo }}">
		<link rel="shortcut icon" href="{{ $webLogo }}">
		<link rel="apple-touch-icon" href="{{ $webLogo }}">
		<link rel="mask-icon" href="{{ $webLogo }}">

		{{-- COMMON LIBS --}}
		<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ mix('css/util/animations.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ mix('css/util/custom-scrollbar.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ mix('css/util/highlight-fragment.css') }}">
		<script type="text/javascript" src="{{ mix('js/app.js') }}" data-auto-add-css="false"></script>

		{{-- CUSTOM STYLES --}}
		<link rel="stylesheet" type="text/css" href="{{ mix('views/layouts/public/public.css') }}">
		@stack('css')

		{{-- TITLE --}}
		<title>{{ $webName }} | @yield('title')</title>
	</head>

	<body class="custom-scrollbar apply-to-all bg-it-quaternary hf-outline-only hf-flash">
		{{-- NOSCRIPT --}}
		@php ($noCarousel = isset($noCarousel) ? $noCarousel : false)
		@include('includes.noscript')

		<div class="d-flex flex-column min-vh-100 js-only position-relative">
			{{-- HEADER --}}
			<header class="header shadow-lg">
				@include('includes.header')
			</header>

			{{-- CONTENTS --}}
			<main class="content d-flex flex-column flex-grow-1 my-5 bg-transparent {{ $noCarousel ? 'no-carousel' : '' }}" id="content">
				<div class="container-fluid content flex-fill m-0">
					@yield('content')
				</div>
			</main>

			{{-- FOOTER --}}
			<footer class="footer">
				@include('includes.footer')
			</footer>
		</div>

		{{-- SCRIPTS --}}
		@include('includes.swal-flash')
		<script type="text/javascript" src="{{ mix('views/layouts/public/public.js') }}"></script>

		{{-- CUSTOM SCRIPTS --}}
		<script type="text/javascript" src="{{ mix('js/util/animation.js') }}"></script>
		<script type="text/javascript" src="{{ mix('js/util/swal-flash.js') }}"></script>
		@stack('scripts')
	</body>
</html>
