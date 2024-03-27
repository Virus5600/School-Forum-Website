@extends('layouts.auth', ['noBlur' => true, 'position' => 'posabs-center', 'formWidth' => 'w-75'])

@section('title', 'Register')

@section('content')
<form class="card floating-header bg-it-primary text-white border rounded border-it-secondary" method="POST" action="{{ route("authenticate") }}" enctype="multipart/form-data" autocomplete="off">
	<h1 class="card-header card-title h3 bg-it-primary border rounded border-it-secondary">Register</h1>

	<div class="card-body">
		<div class="row row-cols-1 row-cols-md-2 g-3">
			{{-- AVATAR --}}
			<div class="col">
				<div class="card card-body bg-it-secondary"></div>
			</div>

			{{-- PERSONAL INFORMATION --}}
			<div class="col">
				<div class="card card-body bg-it-secondary"></div>
			</div>

			{{-- ACCOUNT INFORMATION --}}
			<div class="col w-100">
				<div class="card card-body bg-it-secondary"></div>
			</div>
		</div>
	</div>
</form>

@include('includes.password-tips')
@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}" nonce="{{ csp_nonce() }}">
	<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}" nonce="{{ csp_nonce() }}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{{ mix('views/login/login.js') }}" nonce="{{ csp_nonce() }}"></script>
@endpush
