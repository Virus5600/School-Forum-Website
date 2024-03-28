@extends('layouts.auth', ['noBlur' => true, 'position' => 'posabs-center', 'formWidth' => 'w-100 w-lg-75'])

@section('title', 'Register')

@section('content')
<form class="card floating-header floating-footer bg-it-primary text-white border rounded border-it-secondary m-lg-1" method="POST" action="{{ route("register.store") }}" enctype="multipart/form-data">
	<h1 class="z-3 card-header card-title h3 bg-it-primary border rounded border-it-secondary">Register</h1>

	{{-- ACTUAL FORM --}}
	<div class="z-0 card-body max-vh-75 overflow-auto scroll-bg-transparent" style="--custom-scrollbar-color: rgb(248 249 250); --custom-scrollbar-hover: rgb(173 181 189); --custom-scrollbar-active: rgb(222 226 230);">
		@csrf

		<div class="row row-cols-1 row-cols-md-2 g-3">
			{{-- AVATAR --}}
			<div class="col">
				<div class="card card-body bg-it-secondary h-100">
					<h2 class="card-title">Avatar</h2>

					{{-- IMAGE INPUT --}}
					<div class="image-input-scope" id="avatar-scope" data-settings="#image-input-settings" data-fallback-img="{{ asset('uploads/users/default-male.png') }}">
						{{-- FILE IMAGE --}}
						<div class="form-group text-center image-input collapse show avatar_holder" id="avatar-image-input-wrapper">
							<div class="h-100 row py-2 mx-1">
								<div class="col-12 col-lg-8 justify-content-start">
									<label class="form-label font-weight-bold sr-only" for="avatar">User Image</label>

									<div class="hover-cam mx-auto input-avatar rounded-circle overflow-hidden border border-lg-0" style="--input-avatar-size: 15rem;">
										<img src="{{ asset('uploads/users/default-male.png') }}" class="hover-zoom img-fluid input-avatar" id="avatar-file-container" alt="User Avatar" data-default-src="{{ asset('uploads/users/default-male.png') }}" style="--input-avatar-size: 15rem;">
										<span class="icon text-center image-input-float" id="avatar" tabindex="0">
											<i class="fas fa-camera text-white hover-icon-2x" tabindex="-1"></i>
										</span>
									</div>

									<input type="file" tabindex="-1" name="avatar" class="d-none sr-only" accept=".jpg,.jpeg,.png,.webp" data-target-image-container="#avatar-file-container" data-target-name-container="#avatar-name" >
									<h6 id="avatar-name" class="text-truncate w-50 mx-auto text-center" data-default-name="default.png">default.png</h6>
								</div>

								<div class="col-12 col-lg-4 text-lg-start text-gray-200 vstack gap-3 justify-content-center align-items-center">
									<small class="pb-0 mb-0">
										<b>ALLOWED FORMATS:</b>
										<br>JPEG, JPG, PNG, WEBP
									</small>
									<small class="pt-0 mt-0"><b>MAX SIZE:</b> 5MB</small><br>

									{{-- AVATAR ERROR --}}
									@error('avatar')
									<span class="small badge text-bg-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- PERSONAL INFORMATION --}}
			<div class="col">
				<div class="card card-body bg-it-secondary h-100">
					<h2 class="card-title">Personal Information</h2>

					{{-- Personal Information: Reason for gathering --}}
					<div class="small">
						<p class="card-text">
							We collect your personal information for various purposes and
							to provide you with our services. This includes account creation
							and management, identification, communication, and security.
						</p>

						<p class="card-text">
							Want to learn more about how we handle your data? Check out our
							<a href="javascript:SwalFlash.info('Privacy Policy is not yet implemented.');" class="link-primary" data-bs-theme="dark">Privacy Policy</a>.
						</p>
					</div>

					<hr class="opacity-87.5">

					<div class="row">
						{{-- FIRST NAME --}}
						<div class="col-12 col-lg-4">
							<div class="form-group">
								<label for="first_name" class="form-label required-after">First Name</label>

								<input type="text" class="form-control py-1" name="first_name" id="first_name" required>
							</div>
						</div>

						{{-- MIDDLE NAME --}}
						<div class="col-12 col-lg-3">
							<div class="form-group">
								<label for="middle_name" class="form-label">Middle Name</label>

								<input type="text" class="form-control py-1" name="middle_name" id="middle_name">
							</div>
						</div>

						{{-- LAST NAME --}}
						<div class="col-12 col-lg-3">
							<div class="form-group">
								<label for="last_name" class="form-label required-after">Last Name</label>

								<input type="text" class="form-control py-1" name="last_name" id="last_name" required>
							</div>
						</div>

						{{-- SUFFIX --}}
						<div class="col-12 col-lg-2">
							<div class="form-group">
								<label for="suffix" class="form-label">Suffix</label>

								<input type="text" class="form-control py-1" name="suffix" id="suffix">
							</div>
						</div>

						{{-- GENDER --}}
						<div class="col-12">
							<div class="form-group">
								<label for="gender" class="form-label required-after">Gender</label>

								<select class="form-select py-1" name="gender" id="gender" required>
									@if (!old('gender'))
									<option class="d-none">Select Gender</option>
									@endif
									<option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
									<option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
									<option value="others" {{ old('gender') === 'others' ? 'selected' : '' }}>Others</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- ACCOUNT INFORMATION --}}
			<div class="col w-100">
				<div class="card card-body bg-it-secondary h-100">
					<h2 class="card-title">Account Information</h2>

					{{-- Account Information: Reason for gathering --}}
					<div class="small">
						<p class="card-text">
							We collect your account information to provide you with our services.
							This includes account creation and management, identification, communication,
							and security.
						</p>

						<p class="card-text">
							Want to learn more about how we handle your data? Check out our
							<a href="javascript:SwalFlash.info('Privacy Policy is not yet implemented.');" class="link-primary" data-bs-theme="dark">Privacy Policy</a>.
						</p>
					</div>

					<hr class="opacity-87.5">

					<div class="row">
						{{-- USERNAME --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="username" class="form-label required-after">Username</label>

								<input type="text" class="form-control py-1" name="username" id="username" required>
							</div>
						</div>

						{{-- EMAIL --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="email" class="form-label required-after">Email</label>

								<input type="email" class="form-control py-1" name="email" id="email" required>
							</div>
						</div>

						{{-- PASSWORD --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="password" class="form-label required-after">Password</label>

								<div class="input-group">
									<input id="password" type="password" name="password" class="form-control bg-light border-end-0 border-style-none" required>
									<button type="button" class="btn btn-light border-start-0 border-style-none" id="toggle-show-password" aria-label="Show Password" data-target="#password">
										<i id="show" class="fas fa-eye d-none text-dark" title="Show"></i>
										<i id="hide" class="fas fa-eye-slash text-dark" title="Hide"></i>
									</button>
								</div>
							</div>
						</div>

						{{-- CONFIRM PASSWORD --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="password_confirmation" class="form-label required-after">Confirm Password</label>

								<div class="input-group">
									<input id="password_confirmation" type="password" name="password_confirmation" class="form-control bg-light border-end-0 border-style-none" required>
									<button type="button" class="btn btn-light border-start-0 border-style-none" id="toggle-show-password" aria-label="Show Password" data-target="#password_confirmation">
										<i id="show" class="fas fa-eye d-none text-dark" title="Show"></i>
										<i id="hide" class="fas fa-eye-slash text-dark" title="Hide"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- FORM BUTTONS --}}
	<div class="z-3 card-footer bg-it-primary text-white border rounded border-it-secondary footer-center">
		<div class="hstack gap-3">
			{{-- REGISTER BUTTON --}}
			<button type="submit" class="btn btn-it-secondary text-white">Register</button>

			{{-- RESET BUTTON --}}
			<button type="reset" class="btn btn-dark text-white">Reset</button>
		</div>
	</div>
</form>
@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}" nonce="{{ csp_nonce() }}">
	<link rel="stylesheet" type="text/css" href="{{ mix('views/login/login.css') }}" nonce="{{ csp_nonce() }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/util/image-input.css') }}" nonce="{{ csp_nonce() }}">
@endpush

@push('scripts')
	@include('includes.password-tips')
	<script type="text/javascript" src="{{ mix('views/login/login.js') }}" nonce="{{ csp_nonce() }}"></script>
	<script type="text/javascript" src="{{ mix('js/util/image-input.js') }}" nonce="{{ csp_nonce() }}"></script>
	<script type="text/javascript" src="{{ mix('js/util/swal-flash.js')  }}" nonce="{{ csp_nonce() }}"></script>
@endpush
