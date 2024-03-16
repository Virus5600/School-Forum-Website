<!-- FOOTER -->
<div class="container-fluid" data-bs-theme="dark">
	<div class="row py-3 bg-it-primary">
		<div class="col-12 col-md-3 text-center">
			<div class="d-flex flex-column">
				<h5 class="fw-bold mb-3 text-light">Site Pages</h5>
				<a href="{{ route('home') }}" class="small my-1 text-decoration-none link-body-emphasis">Home</a>
				<a href="{{ route('home') }}" class="small my-1 text-decoration-none link-body-emphasis">Downloads</a>
				<a href="{{ route('home') }}" class="small my-1 text-decoration-none link-body-emphasis">Installations</a>
				<a href="{{ route('home') }}" class="small my-1 text-decoration-none link-body-emphasis">Contents</a>
			</div>
		</div>

		<div class="col-12 col-md-3 text-center">
			<div class="d-flex flex-column">
				<h6 class="fw-bold mb-3 text-light">Technical Stuff</h6>
				<a href="{{ route('home') }}" class="small my-1 text-decoration-none link-body-emphasis">Privacy Policy</a>
				<a href="{{ route('home') }}" class="small my-1 text-decoration-none link-body-emphasis">About</a>
			</div>
		</div>

		<div class="col-12 col-md-6">
			<div class="d-flex flex-row">
				<a href="{{ route('home') }}" class="ms-md-auto w-100 w-md-50 w-lg-25 text-decoration-none" aria-label="Defensive Measures Guide">
					<div class="d-flex-flex-row align-items-end">
						<div class="d-flex flex-column align-items-center">
							<img src="{{ $webLogo }}" alt="{{ $webName }}" class="p-2 img img-fluid border rounded-circle bg-it-quaternary">
							<h4 class="link-body-emphasis">{{ $webName }}</h4>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
