@extends('layouts.auth', ['noBlur' => true, 'position' => 'posabs-center', 'formWidth' => 'w-100 w-lg-75'])

@section('title', 'Register')

@section('content')
<form class="card floating-header floating-footer bg-it-primary text-white border rounded border-it-secondary m-2" method="POST" action="{{ route("register.store") }}" enctype="multipart/form-data">
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
					<div class="image-input-scope drag-drop rounded" id="avatar-scope" data-settings="#image-input-settings" data-fallback-img="{{ asset('uploads/users/default-male.png') }}">
						{{-- FILE IMAGE --}}
						<div class="form-group text-center image-input collapse show avatar_holder" id="avatar-image-input-wrapper">
							<div class="h-100 row py-2 mx-1">
								<div class="col-12 col-lg-8 form-control justify-content-start position-relative w-auto bg-transparent {{ $errors->count() > 0 ? ($errors->has('avatar') ? 'is-invalid' : 'is-valid') : '' }}">
									<label class="form-label font-weight-bold sr-only" for="avatar">User Image</label>

									{{-- HOVER CAM --}}
									<div class="hover-cam mx-auto input-avatar rounded-circle overflow-hidden border border-lg-0" style="--input-avatar-size: 15rem;">
										<img src="{{ asset('uploads/users/default-male.png') }}" class="hover-zoom img-fluid input-avatar" id="avatar-file-container" alt="User Avatar" data-default-src="{{ asset('uploads/users/default-male.png') }}">
										<span class="icon text-center image-input-float" id="avatar" tabindex="0">
											<i class="fas fa-camera text-white hover-icon-2x" tabindex="-1"></i>
										</span>

										{{-- DRAG-DROP OVERLAY --}}
										<div class="drag-drop-overlay animated rounded-circle overflow-hidden border-0">
											<i class="fas fa-upload 2x text-white"></i>
										</div>
									</div>


									{{-- ACTUAL INPUTS --}}
									<input type="file" tabindex="-1" name="avatar" class="d-none sr-only" accept=".jpg,.jpeg,.png,.webp" data-target-image-container="#avatar-file-container" data-target-name-container="#avatar-name" >
									<h6 id="avatar-name" class="text-truncate w-50 mx-auto text-center" data-default-name="default.png">default.png</h6>
								</div>

								<div class="col-12 col-lg-4 text-lg-start text-gray-200 vstack gap-3 justify-content-center align-items-center">
									<hr class="d-block d-lg-none w-100 border-3 opacity-75">

									<small class="p text-center">
										<b>INSTRUCTIONS:</b>
										<br>Click the camera icon to upload an image.
									</small>

									<small class="pb-0 mb-0">
										<b>ALLOWED FORMATS:</b>
										<br>JPEG, JPG, PNG, WEBP
									</small>
									<small class="pt-0 mt-0"><b>MAX SIZE:</b> 5MB</small>
									<button type="button" class="btn btn-it-primary btn-sm image-input-reset" data-target-image-container="#avatar-file-container" data-target-name-container="#avatar-name">Remove Image</button>

									{{-- AVATAR ERROR --}}
									<x-forms.validation-error field="avatar"/>
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
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="first_name" class="form-label required-after">First Name</label>
								<x-forms.input-field name="first_name" value="{{ old('first_name') }}" required="true" />
								<x-forms.validation-error field="first_name"/>
							</div>
						</div>

						{{-- MIDDLE NAME --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="middle_name" class="form-label">Middle Name</label>
								<x-forms.input-field name="middle_name" value="{{ old('middle_name') }}" />
								<x-forms.validation-error field="middle_name"/>
							</div>
						</div>

						{{-- LAST NAME --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="last_name" class="form-label required-after">Last Name</label>
								<x-forms.input-field name="last_name" value="{{ old('last_name') }}" required="true" />
								<x-forms.validation-error field="last_name"/>
							</div>
						</div>

						{{-- SUFFIX --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="suffix" class="form-label">Suffix</label>
								<x-forms.input-field name="suffix" value="{{ old('suffix') }}" />
								<x-forms.validation-error field="suffix"/>
							</div>
						</div>

						{{-- GENDER --}}
						<div class="col-12">
							<div class="form-group">
								<label for="gender" class="form-label required-after">Gender</label>

								<select class="form-select py-1 {{ $errors->count() > 0 ? ($errors->has('gender') ? 'is-invalid' : 'is-valid') : '' }}" name="gender" id="gender" pattern="male|female|others" required>
									@if (!old('gender'))
									<option class="d-none" value>Select Gender</option>
									@endif
									<option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
									<option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
									<option value="others" {{ old('gender') === 'others' ? 'selected' : '' }}>Others</option>
								</select>

								<x-forms.validation-error field="gender"/>
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
								<x-forms.input-field name="username" value="{{ old('username') }}" required="true" />
								<x-forms.validation-error field="username"/>
							</div>
						</div>

						{{-- EMAIL --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="email" class="form-label required-after">Email</label>
								<x-forms.input-field name="email" value="{{ old('email') }}" type="email" required="true" />
								<x-forms.validation-error field="email"/>
							</div>
						</div>

						{{-- PASSWORD --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="password" class="form-label required-after">Password</label>

								<div class="input-group">
									<input id="password" type="password" name="password" class="form-control bg-light border-style-solid" required>
									<button type="button" class="btn btn-light border border-start-0 border-style-solid border-dark-subtle toggle-show-password" aria-label="Show Password" data-target="#password">
										<i id="show" class="fas fa-eye d-none text-dark" title="Show"></i>
										<i id="hide" class="fas fa-eye-slash text-dark" title="Hide"></i>
									</button>
								</div>

								<x-forms.validation-error field="password"/>
							</div>
						</div>

						{{-- CONFIRM PASSWORD --}}
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="password_confirmation" class="form-label required-after">Confirm Password</label>

								<div class="input-group">
									<input id="password_confirmation" type="password" name="password_confirmation" class="form-control bg-light border-style-solid" required>
									<button type="button" class="btn btn-light border border-start-0 border-style-solid border-dark-subtle toggle-show-password" aria-label="Show Password" data-target="#password_confirmation">
										<i id="show" class="fas fa-eye d-none text-dark" title="Show"></i>
										<i id="hide" class="fas fa-eye-slash text-dark" title="Hide"></i>
									</button>
								</div>

								<x-forms.validation-error field="password_confirmation"/>
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

			{{-- GO BACK --}}
			<a href="{{ route('login') }}" class="btn btn-secondary text-white">Back to Login</a>
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

	{{-- Re-add image in image-inputs --}}
	@if ($errors->count() > 0 || session()->has('error'))
	<script type="text/javascript" nonce="{{ csp_nonce() }}" data-ii-to-remove>
		window.imageInputError = true;
	</script>
	@endif

	<script type="text/javascript" src="{{ mix('views/login/login.js') }}" nonce="{{ csp_nonce() }}"></script>
	<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}" nonce="{{ csp_nonce() }}"></script>
	<script type="text/javascript" src="{{ mix('js/util/image-input.js') }}" nonce="{{ csp_nonce() }}"></script>
	<script type="text/javascript" src="{{ mix('js/util/swal-flash.js')  }}" nonce="{{ csp_nonce() }}"></script>
@endpush
