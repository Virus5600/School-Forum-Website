{{-- Navigation Bar --}}
<nav class="navbar navbar-expand-md fixed-top shadow-lg px-3 bg-it-primary" id="mainNavbar" data-bs-theme="dark">
	{{-- Branding --}}
	<a href="{{ route('home') }}" class="navbar-brand m-0 link-body-emphasis">
		<img src="{{ $webLogo }}" alt="{{ $webName }} Logo" class="m-0" draggable="false">
		{{ $webName }}
	</a>

	{{-- Navbar Toggler (on small screens) --}}
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle Navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	{{-- Navbar Contents --}}
	<div class="collapse navbar-collapse" id="navbarContent">
		<ul class="navbar-nav nav-underline navbar-nav-scroll text-bg-dark bg-it-primary ms-auto text-center text-lg-start row-gap-2">
			{{-- HOME --}}
			<li class="nav-item">
				@if (\Request::is('/'))
				<span class="nav-link active">Home</span>
				@else
				<a href="{{ route('home') }}" class="nav-link">Home</a>
				@endif
			</li>

			{{-- DISCUSSION --}}
			<li class="nav-item">
				@if (\Request::is('discussions'))
				<span class="nav-link active">Discussions</span>
				@elseif (\Request::is('discussions*'))
				<a href="{{ route('discussions.index') }}" class="nav-link active">Discussions</a>
				@else
				<a href="{{ route('discussions.index') }}" class="nav-link">Discussions</a>
				@endif
			</li>

			{{-- ANNOUNCEMENTS --}}
			<li class="nav-item">
				@if (\Request::is('announcements'))
				<span class="nav-link active">Announcements</span>
				@elseif (\Request::is('announcements*'))
				<a href="{{ route('announcements.index') }}" class="nav-link active">Announcements</a>
				@else
				<a href="{{ route('announcements.index') }}" class="nav-link">Announcements</a>
				@endif
			</li>

			{{-- LOST & FOUND --}}
			<li class="nav-item">
				@if (\Request::is('lost-and-found'))
				<span class="nav-link active">Lost & Found</span>
				@elseif (\Request::is('lost-and-found*'))
				<a href="{{ route('lost-and-found.index') }}" class="nav-link active">Lost & Found</a>
				@else
				<a href="{{ route('lost-and-found.index') }}" class="nav-link">Lost & Found</a>
				@endif
			</li>

			{{-- SEPARATOR --}}
			<li class="nav-item">
				<div class="vr h-100 d-none d-lg-block bg-it-secondary opacity-75" style="width: 2.5px;"></div>
				<hr class="w-100 d-block d-lg-none my-0" style="border-width: 2.5px;">
			</li>

			{{-- Additional directories if authenticated --}}
			@auth
			{{-- ADMIN DIRECTORIES --}}
			<li class="nav-item">
				<div class="dropdown my-auto">
					{{-- Dropdown Trigger --}}
					<a href="#" role="button" class="nav-link dropdown-toggle fs-6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{!! auth()->user()->getAvatar(type: 'html', additionalClasses: 'avatar avatar-5 rounded-circle') !!}
						{{ auth()->user()->getName() }}
					</a>

					<div class="dropdown-menu dropdown-menu-end text-center text-lg-end text-bg-dark bg-it-primary" style="--bs-dropdown-link-hover-bg: var(--bs-it-secondary)">
						{{-- DASHBOARD --}}
						<a href="{{ route('admin.dashboard') }}" class="dropdown-item transition-2">Dashboard</a>

						<div class="dropdown-divider"></div>

						{{-- LOGOUT --}}
						<form action="{{ route('logout') }}" method="POST" class="dropdown-item transition-2">
							@csrf
							<button type="submit" class="remove-button-style w-100 text-center text-lg-end">Logout</button>
						</form>
					</div>
				</div>
			</li>
			@else
			{{-- LOGIN --}}
			<li class="nav-item">
				@if (\Request::is('login'))
				<span class="nav-link active">Login</span>
				@elseif (\Request::is('login*'))
				<a href="{{ route('login') }}" class="nav-link active">Login</a>
				@else
				<a href="{{ route('login') }}" class="nav-link">Login</a>
				@endif
			</li>

			{{-- REGISTER --}}
			<li class="nav-item">
				@if (\Request::is('register'))
				<span class="nav-link active">Register</span>
				@elseif (\Request::is('register*'))
				<a href="{{ route('register') }}" class="nav-link active">Register</a>
				@else
				<a href="{{ route('register') }}" class="nav-link">Register</a>
				@endif
			</li>
			@endauth
		</ul>
	</div>
</nav>

{{-- Carousel --}}
@if (!$noCarousel)
<section class="container-fluid">
	<div class="row">
		<div class="col-12 px-0" id="masthead">
			<div class="carousel arrow-xs-3 arrow-lg-4 arrow-inside js-only">
				@forelse($carousel as $c)
				<div class="bg-it-secondary carousel-item" style="--bg-img: url('{{ $c->getImage($type="url") }}')">
					<div class="opacity-lg-100 opacity-0 backdrop-blur-lg-3">
						{!! $c->getImage() !!}
					</div>
				</div>
				@empty
				<div class="bg-it-secondary">
					<div class="backdrop-blur-lg-3">
						<h3 class="text-center p-5">Nothing for now</h3>
					</div>
				</div>
				@endforelse
			</div>
		</div>
	</div>
</section>
@endif
