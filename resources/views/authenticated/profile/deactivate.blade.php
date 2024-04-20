@extends('layouts.public', ['noCarousel' => true, 'additionalBodyClasses' => 'no-blur'])

@section('title', 'Profile - Change Password')

@section('content')
<hgroup class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
	{{ Breadcrumbs::render() }}
</hgroup>

<hr>

<form action="{{ route('profile.deactivate.confirmed') }}" method="POST"
	class="vstack justify-content-center align-items-center my"
	data-cl-form
	data-cl-form-submit
	data-cl-form-submit-title="Are you sure?"
	data-cl-form-submit-message="Are you sure you want to deactivate your account? You can always reactivate your account by logging in."
	>
	<div class="card floating-header floating-footer w-100 w-md-75">
		<div class="card-header bg-white border rounded header-center header-md-start">
			<h3 class="card-title">Deactivate Account</h3>
		</div>

		<div class="card-body rounded vstack gap-5">
			{{-- META INPUTS --}}
			@csrf
			@method('DELETE')

			<section>
				<h5 class="card-title">Deactivation</h5>
				<hr>
				<p class="card-text">
					By deactivating your account, you will disable your account and remove your profile from the site temporarily.
					You will be logged out and will not be able to log back in until you reactivate your account.
				</p>
			</section>

			<section>
				<h5 class="card-title">What will happen to your data?</h5>
				<hr>
				<p class="card-text">
					When you deactivate your account, your profile will be removed from the site and your data will be archived.
					Your data will not be deleted and will be retained for a period of time in case you decide to reactivate your account,
					allowing you to restore your profile and continue using the site as normal.
				</p>

				<p class="card-text">
					Your data will still be subject to our <a href="{{ route('privacy-policy') }}">Privacy Policy</a> and will be handled in accordance with
					our data retention policy. If you would like to request a copy of your data or have your data deleted, please contact us.
				</p>

				<p class="card-text">
					Please note that some data may be retained for legal or regulatory purposes, such as transaction records or other data required
					for compliance with laws and regulations.
				</p>
			</section>

			<section>
				<h5 class="card-title">Reactivation</h5>
				<hr>
				<p class="card-text">
					To reactivate your account, simply log back in with your email and password. This will reactivate your account and
					restore your profile, allowing you to continue using the site as normal.
				</p>

				<p class="card-text">
					Please note that you will need to re-verify your email address and complete any additional steps required to reactivate your account.
					If you have any issues or need assistance with reactivating your account, please contact us and we will be happy to help.
				</p>
			</section>

			<section>
				<h5 class="card-title">Account Deletion</h5>
				<hr>
				<p class="card-text">
					If you would like to permanently delete your account and all associated data, please contact us and we will assist you with the process.
					Please note that account deletion is permanent and cannot be undone. Once your account is deleted, all data will be removed and cannot be recovered.
				</p>

				<p class="card-text">
					Please note that account deletion is different from account deactivation. Deactivating your account will temporarily disable your profile and
					allow you to reactivate it at a later time. Deleting your account will <span class="text-danger fw-bold">permanently remove</span> your profile and all associated data from the site.
				</p>
			</section>

			<hr>

			<section class="card floating-header border rounded">
				<h5 class="card-header border rounded bg-white">
					<label for="reason" class="card-title form-label">
						Reason for Deactivation
					</label>
				</h5>

				<div class="card-body border rounded bg-white">
					<p class="card-text">
						Please provide a reason for deactivating your account. This will help us improve our services and understand why you are choosing to deactivate your account.
						Your feedback is important to us and will help us make the site better for all users.
					</p>

					<p class="card-text">
						This is optional, but we appreciate any feedback you can provide. Your reason will be kept confidential and will not be shared with other users.
						Your reason will also be included in the deactivation notification email that you will receive after deactivating your account.
					</p>

					<div class="list-group my-3">
						<label for="temporary" class="list-group-item form-check form-check-label my-0">
							<input type="radio" name="reason" class="form-check-input me-1" id="temporary"
								value="Just a temporary deactivation. I'll be back."
								>
							Just a temporary deactivation. I'll be back.
						</label>

						<label for="not-useful" class="list-group-item form-check form-check-label my-0">
							<input type="radio" name="reason" class="form-check-input me-1" id="not-useful"
								value="I don't find {{ $webName }} useful"
								>
							I don't find {{ $webName }} useful
						</label>

						<label for="not-understand" class="list-group-item form-check form-check-label my-0">
							<input type="radio" name="reason" class="form-check-input me-1" id="not-understand"
								value="I don't understand how to use {{ $webName }}"
								>
							I don't understand how to use {{ $webName }}
						</label>

						<label for="too-much-time" class="list-group-item form-check form-check-label my-0">
							<input type="radio" name="reason" class="form-check-input me-1" id="too-much-time"
								value="I spent too much time in {{ $webName }}"
								>
							I spent too much time in {{ $webName }}
						</label>

						<label for="others" class="list-group-item form-check form-check-label my-0" for="others">
							<input type="radio" name="reason" class="form-check-input me-1" id="others"
								data-ofc-parent
								data-ofc-targets="#reason"
								>
							Others:
						</label>
					</div>

					<div class="text-counter-parent">
						<textarea name="reason" id="reason" class="form-control not-resizable text-counter-input"
							placeholder="Reason for deactivating your account..."
							data-tc-restrict="true"
							data-tc-max="255"
							data-tc-warn-at="25"
							disabled
							>{{ old('reason') }}</textarea>
						<span class="text-counter">{{ old('reason') ? (255 - strlen(old('reason'))) : 255 }}</span>
					</div>
				</div>
			</section>
		</div>

		<div class="card-footer bg-white border rounded footer-center footer-md-end">
			{{-- Deactivate Button --}}
			<button type="submit" class="btn btn-danger">Deactivate Account</button>

			{{-- Go Back Button --}}
			<a href="{{ route('profile.index') }}" class="btn btn-dark">Go Back</a>
		</div>
	</div>
</form>
@endsection

@push('css')
<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
<link rel="stylesheet" href="{{ mix('css/util/text-counter.css') }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ mix('js/util/text-counter.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/util/others-field-control.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/util/confirm-leave.js') }}"></script>
@endpush
