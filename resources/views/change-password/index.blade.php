@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
{{-- FORGOT PASSWORD FORM START --}}
<div class="card floating-header bg-it-primary text-white border-white">
	<div class="card-header header-center header-md-start border border-white rounded bg-it-primary">
		<h1 class="card-title d-flex flex-row position-relative h3">
			<span class="m-auto">Forgot Password</span>

			@include('includes.auth.lock-view', ['absolutePosition' => false])
		</h1>
	</div>

	<div class="card-body" id="form">
		<form action="@{{ route('forgot-password.submit') }}" method="POST">
		@csrf

		<div class="form-group">
			<label class="form-label" for="identifier">Username or Email</label>
				<input class="form-control border-secondary" type="text" name="identifier" value="{{ old('identifier') ? old('identifier') : $identifier }}" aria-label="Username or E-mail" placeholder="Username or E-mail" />
				<x-forms.validation-error field="email" />
			</div>

			<div class="form-group text-center mt-3">
				<button type="submit" class="btn btn-it-secondary" data-action="submit">Submit</button>
			</div>
		</form>
	</div>
	{{-- FORGOT PASSWORD FORM END --}}
@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{{ mix('views/login/login.js') }}"></script>
@endpush
