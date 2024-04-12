@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Profile')

@section('content')
<div class="container-fluid">
	<hgroup class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
		{{ Breadcrumbs::render() }}

		<a href="{{ route('discussions.create') }}" class="btn btn-it-primary icon-link icon-link-hover" title="Edit your profile." style="--bs-icon-link-transform: scale(1.125);">
			<i class="fas fa-user-pen bi"></i>
			Edit Profile
		</a>
	</hgroup>

	<hr>

	{{-- Content --}}
	<section class="card floating-header border-0 bg-transparent my-6">
		<div class="card-header bg-transparent border-0">
			<h2 class="m-0 p-2 display-3 gap-3 d-flex flex-column flex-md-row justify-content-center justify-content-md-start">
				<span class="d-flex align-items-center">
					{!! auth()->user()->getAvatar(type: 'html', additionalClasses: 'avatar avatar-2xl avatar-md-10 rounded-circle cw-unaffected') !!}
				</span>

				<span class="text-center text-md-start">
					{{ auth()->user()->getName() }}
				</span>
			</h2>
		</div>

		<div class="card-body">
			{{-- PERSONAL INFORMATION --}}
			<div class="d-flex flex-column my-3">
				<h3 class="display-6">Personal Information:</h3>

				<div class="row">
					{{-- First Name --}}
					<div class="form-group col-12 col-sm-6 col-md-3 p-md-3">
						<label for="first_name" class="form-label">First Name</label>
						<input type="text" id="first_name" class="form-control" value="{{ auth()->user()->first_name }}" readonly>
					</div>

					{{-- Middle Name --}}
					<div class="form-group col-12 col-sm-6 col-md-2 p-md-3">
						<label for="middle_name" class="form-label">Middle Name</label>
						<input type="text" id="middle_name" class="form-control" value="{{ auth()->user()->middle_name }}" readonly>
					</div>

					{{-- Last Name --}}
					<div class="form-group col-12 col-sm-6 col-md-3 p-md-3">
						<label for="last_name" class="form-label">Last Name</label>
						<input type="text" id="last_name" class="form-control" value="{{ auth()->user()->last_name }}" readonly>
					</div>

					{{-- Suffix --}}
					<div class="form-group col-12 col-sm-3 col-md-2 p-md-3">
						<label for="suffix" class="form-label">Suffix</label>
						<input type="text" id="suffix" class="form-control" value="{{ auth()->user()->suffix }}" readonly>
					</div>

					{{-- Gender --}}
					<div class="form-group col-12 col-sm-3 col-md-2 p-md-3">
						<label for="gender" class="form-label">Gender</label>
						<input type="text" id="gender" class="form-control" value="{{ ucwords(auth()->user()->gender) }}" readonly>
					</div>
				</div>
			</div>

			{{-- ACCOUNT INFORMATION --}}
			<div class="d-flex flex-column my-3">
				<h3 class="display-6">Account Information</h3>

				<div class="row">
					{{-- Username --}}
					<div class="form-group col-12 col-sm-6 col-lg-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" id="username" class="form-control" value="{{ auth()->user()->username }}" readonly>
					</div>

					{{-- Email --}}
					<div class="form-group col-12 col-sm-6 col-lg-3">
						<label for="email" class="form-label">Email</label>
						<input type="email" id="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
					</div>

					{{-- Date Joined --}}
					<div class="form-group col-12 col-sm-6 col-lg-3">
						<label for="date_joined" class="form-label">Date Joined</label>
						<input type="text" id="date_joined" class="form-control" value="{{ auth()->user()->created_at->format('F j, Y (H:i A)') }}" readonly>
					</div>

					{{-- Last Accessed --}}
					<div class="form-group col-12 col-sm-6 col-lg-3">
						<label for="last_accessed" class="form-label">Last Accessed</label>
						<input type="text" id="last_accessed" class="form-control" value="{{ auth()->user()->last_auth->format('F j, Y (H:i A)') }}" readonly>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{-- Account Activity --}}
	<section class="card floating-hard border-0 bg-transport my-6">
		<h2 class="card-header bg-transparent border-0 display-3">
			Account Activity
		</h2>

		<div class="card-body">
		</div>
	</section>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
