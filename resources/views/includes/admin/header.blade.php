{{-- Navigation Bar (TOP) --}}
<nav class="navbar navbar-expand-lg shadow-lg px-3 text-bg-dark bg-it-primary font-minecraftia" style="z-index: 1000;" data-bs-theme="dark">
	<div class="container-fluid">
		{{-- Branding --}}
		<a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-auto mx-lg-0 py-0 h-auto d-none d-lg-block text-light">
			<img src="{{ $webLogo }}" alt="Defensive Measures Icon" style="max-height: 3.25rem;" class="m-0 p-0 me-2">
			{{ $webName }}
		</a>

		<div class="d-flex flex-row mx-auto mx-lg-0">
			{{-- Navbar contents --}}
			<div class="navbar-collapse" id="navbar">
				<div class="ms-auto h-100 d-flex">
					<div class="dropdown my-auto">
						{{-- Dropdown Trigger --}}
						<a href="#" role="button" class="nav-link dropdown-toggle fs-6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{!! auth()->user()->getAvatar(type: 'html', additionalClasses: 'avatar avatar-5 rounded-circle me-2') !!}
							{{ auth()->user()->getName() }}
						</a>

						<div class="dropdown-menu dropdown-menu-end bg-it-primary text-end" style="z-index: 1001;" data-bs-theme="dark">
							{{-- Home Page --}}
							<a href="{{ route('home') }}" class="dropdown-item">View Home Page</a>
							{{-- Profile Page --}}
							<a href="{{ route('profile.index') }}" class="dropdown-item">View Profile</a>

							<div class="dropdown-divider"></div>

							{{-- Logout --}}
							<form action="{{ route('logout') }}" method="POST" class="dropdown-item">
								@csrf
								<button type="submit" class="remove-button-style w-100 text-end">Logout</button>
							</form>
						</div>
					</div>
				</div>
			</div>

			{{-- Navbar Toggler --}}
			<button class="sidebar-toggler" type="button" data-dmg-toggle="sidebar-collapse" data-dmg-target="#sidebar" aria-controls="sidebar" aria-label="Toggle Sidebar" id="sidebar-toggler">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</div>
</nav>
