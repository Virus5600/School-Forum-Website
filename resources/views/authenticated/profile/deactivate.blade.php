@extends('layouts.public', ['noCarousel' => true, 'additionalBodyClasses' => 'no-blur'])

@section('title', 'Profile - Change Password')

@section('content')
<div class="vstack justify-content-center align-items-center">
	<div class="card floating-header floating-footer w-100 w-md-75">
		<div class="card-header bg-white border rounded header-center header-md-start">
			<h3 class="card-title">Deactivate Account</h3>
		</div>

		<div class="card-body rounded vstack gap-5">
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
		</div>

		<form action="{{ route('profile.deactivate.confirmed') }}" method="POST"
			class="card-footer bg-white border rounded footer-center footer-md-end"
			data-cl-form
			data-cl-form-submit
			data-cl-form-submit-title="Are you sure?"
			data-cl-form-submit-message="Are you sure you want to deactivate your account? You can always reactivate your account by logging in."
			>
			@csrf
			@method('DELETE')

			<button type="submit" class="btn btn-danger">Deactivate Account</button>
			<a href="{{ route('profile.index') }}" class="btn btn-dark">Go Back</a>
		</form>
	</div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ mix('js/util/confirm-leave.js') }}"></script>
@endpush
