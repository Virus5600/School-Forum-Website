@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Profile - Edit')

@section('content')
<hgroup class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
	{{ Breadcrumbs::render() }}
</hgroup>

<hr>

<div class="container-fluid">
	<form method="POST" action="{{ route('profile.update') }}" class="card floating-header floating-footer bg-it-primary text-white border rounded border-it-secondary m-lg-1" data-cl-form data-cl-form-reset>
		{{-- Header --}}
		<h1 class="z-3 card-header card-title h3 bg-it-primary border rounded border-it-secondary">
			Edit Profile
		</h1>

		{{-- Body --}}
		<div class="card-body">
			@csrf
			@method('PUT')

			{{-- Content --}}
			<div class="d-flex flex-column gap-5">
				{{-- PERSONAL INFORMATION --}}
				<div class="card floating-header bg-it-secondary text-white border-0">
					<h2 class="card-header card-title h5 bg-it-secondary border-0">
						Personal Information
					</h2>

					<div class="card-body">
						<div class="row">
							{{-- First Name --}}
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label for="first_name" class="form-label required-after">First Name</label>
									<x-forms.input-field name="first_name" value="{{ $user->first_name }}" />
									<x-forms.validation-error field="first_name" />
								</div>
							</div>

							{{-- Middle Name --}}
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label for="middle_name" class="form-label">Middle Name</label>
									<x-forms.input-field name="middle_name" value="{{ $user->middle_name }}" />
									<x-forms.validation-error field="middle_name" />
								</div>
							</div>

							{{-- Last Name --}}
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label for="last_name" class="form-label required-after">Last Name</label>
									<x-forms.input-field name="last_name" value="{{ $user->last_name }}" />
									<x-forms.validation-error field="last_name" />
								</div>
							</div>

							{{-- Suffix --}}
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label for="suffix" class="form-label">Suffix</label>
									<x-forms.input-field name="suffix" value="{{ $user->suffix }}" />
									<x-forms.validation-error field="suffix"/>
								</div>
							</div>

							{{-- Gender --}}
							<div class="col-12">
								<div class="form-group">
									<label for="gender" class="form-label required-after">Gender</label>

									<select class="form-select py-1 {{ $errors->count() > 0 ? ($errors->has('gender') ? 'is-invalid' : 'is-valid') : '' }}" name="gender" id="gender" pattern="male|female|others" required>
										<option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
										<option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
										<option value="others" {{ $user->gender === 'others' ? 'selected' : '' }}>Others</option>
									</select>

									<x-forms.validation-error field="gender"/>
								</div>
							</div>
						</div>
					</div>
				</div>

				{{-- ACCOUNT INFORMATION --}}
				<div class="card floating-header bg-it-secondary text-white border-0">
					<h2 class="card-header card-title h5 bg-it-secondary border-0">
						Account Information
					</h2>

					<div class="card-body">
						<div class="row">
							{{-- Username --}}
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label for="username" class="form-label required-after">Username</label>
									<x-forms.input-field name="username" value="{{ $user->username }}" required="true" />
									<x-forms.validation-error field="username"/>
								</div>
							</div>

							{{-- Email --}}
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label for="email" class="form-label required-after">Email</label>
									<x-forms.input-field name="email" value="{{ $user->email }}" type="email" required="true" />
									<x-forms.validation-error field="email"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Footer --}}
		<div class="z-3 card-footer bg-it-primary text-white border rounded border-it-secondary footer-center">
			<div class="hstack gap-3">
				{{-- UPDATE BUTTON --}}
				<button type="submit" class="btn btn-it-secondary text-white">Update</button>

				{{-- RESET BUTTON --}}
				<button type="reset" class="btn btn-dark text-white">Reset</button>

				{{-- GO BACK --}}
				<button type="button" class="btn btn-secondary text-white"
					data-cl-leave
					data-cl-leave-href="{{ route('profile.index') }}"
					>
					Back to Profile
				</button>
			</div>
		</div>
	</form>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}" nonce="{{ csp_nonce() }}"></script>
<script type="text/javascript" src="{{ mix('js/util/confirm-leave.js') }}" nonce="{{ csp_nonce() }}"></script>
@endpush
