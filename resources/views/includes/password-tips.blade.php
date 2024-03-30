<div class="alert alert-info alert-dismissible w-100 w-md-auto position-absolute top-0 start-50 translate-middle-x start-md-0 translate-md-start m-md-3 ms-md-0 d-flex align-items-center z-3 rounded-end-md-pill fade" role="alert" id="password-tips" style="left: -100% !important;">
	<i class="fas fa-info-circle fa-3x me-2 flex-shrink-0"></i>

	<div class="d-flex flex-column fs-2xs">
		<h5 class="alert-heading">Password Tips</h5>
		<ul>
			<li>Avoid Reusing Passwords.</li>
			<li>Avoid using common words</li>
			<li>Avoid using something that could<br>be easily associated to you.</li>
			<li>Use a Password Manager.</li>
			<li>Use both upper and lowercase letters</li>
			<li>Include symbols and numbers</li>
		</ul>
		<button type="button" class="btn btn-info fs-2xs mx-auto text-light" data-bs-dismiss="alert" aria-label="Close">Understood</button>
	</div>

	<button type="button" class="btn-close start-unset start-md-0" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@push('scripts')
<script type="text/javascript" src="{{ mix('views/register/register.js') }}"></script>
@endpush
