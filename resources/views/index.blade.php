@extends('layouts.public')

@section('title', 'Home')

@section('content')
<div class="container-fluid body-container bg-it-quaternary">
	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Welcome to {{ $webName }}!</h1>

		<p class="lead text-indent-5">
			{{ $webDesc }}
		</p>
	</hgroup>

	<hr class="my-5">

	{{-- ANNOUNCEMENTS --}}
	<section class="card floating-header bg-transparent border-0">
		<div class="card-header header-center header-lg-start bg-transparent border-0 display-4 text-center text-lg-start transition-3">Announcements</div>

		<div class="card-body">
			<div class="row row-cols-1 row-cols-lg-2 gx-0 gy-3 gx-lg-3">
				{{-- Announcement Items --}}
				@forelse($announcements as $a)
				<article class="col">
					<div class="card text-bg-dark clickable" style="--bs-hoverable-shadow-color: var(--bs-it-tertiary);">
						<img src="{{ $a->getPoster("url") }}" alt="{{ $a->getPoster("filename") }}" class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur text-center text-lg-start">
							<h5 class="card-title display-6">{{ Str::limit(Str::title($a->title), 25) }}</h5>
							<p class="card-text">{{ Str::limit($a->content, 125) }}</p>
						</div>
					</div>
				</article>
				@empty
				{{-- No Announcement --}}
				<div class="col w-100">
					<div class="card text-bg-dark">
						<img src="{{ asset("uploads/announcements/default.png") }}" alt="" class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
							<i class="far fa-folder-open fa-2x"></i>
							<h3 class="card-title m-0">No Announcement Yet...</h3>
						</div>
					</div>
				</div>
				@endforelse
			</div>
		</div>
	</section>

	{{-- LOST & FOUND --}}
	<section class="card floating-header bg-transparent border-0">
		<h2 class="card-header bg-transparent border-0 display-3">Lost & Found</h2>

		<div class="card-body">
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 gx-0 gy-3 gx-md-3">
				{{-- Lost Items --}}
				@forelse($lostItems as $l)
				<article class="col">
					<div class="card text-bg-dark clickable">
						<img src="{{ $l->getImage("url") }}" alt="{{ $l->getImage("filename") }}" class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur text-center text-lg-start">
							<h5 class="card-title display-6">
								<span class="border-bottom border-white">
									Lost: <b>{{ Str::limit(Str::title($l->item_found), 20) }}</b>
								</span>
							</h5>

							<div class="d-flex flex-column">
								<p class="card-text m-0">{{ Str::limit("Found by {$l->founder_name}", 50) }}</p>
								<p class="card-text m-0">{{ Str::limit("Found at {$l->place_found}", 50) }}</p>
								<p class="card-text m-0">{{ Carbon::parse("{$l->date_found} {$l->time_found}")->format("(D) M d, Y h:i A") }}</p>
							</div>
						</div>
					</div>
				</article>
				@empty
				{{-- No Lost Item(s) --}}
				<div class="col w-100">
					<div class="card text-bg-dark">
						<img src="{{ asset("uploads/lost-and-found/default.png") }}" alt="" class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
							<i class="fas fa-box-open fa-3x"></i>
							<h3 class="card-title m-0">No Lost Items</h3>
						</div>
					</div>
				</div>
				@endforelse
			</div>
		</div>
	</section>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endsection

@section('scripts')
@endsection
