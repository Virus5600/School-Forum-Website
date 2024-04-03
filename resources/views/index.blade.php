@extends('layouts.public')

@section('title', 'Home')

@section('content')
<div class="container-fluid body-container">
	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Welcome to {{ $webName }}!</h1>

		<p class="lead text-indent-5">
			{{ $webDesc }}
		</p>
	</hgroup>

	<hr class="my-5">

	{{-- ANNOUNCEMENTS --}}
	<section class="card floating-header floating-footer bg-transparent border-0 mb-10">
		<h2 class="card-header header-center header-lg-start bg-transparent border-0 display-4 text-center text-lg-start transition-3">Announcements</h2>

		<div class="card-body">
			<div class="row row-cols-1 row-cols-lg-2 gx-0 gy-3 gx-lg-3">
				{{-- Announcement Items --}}
				@forelse($announcements as $a)
				<article class="col">
					<a href="{{ route("announcements.show", ["slug" => $a->slug]) }}" class="card text-bg-dark clickable" style="--bs-hoverable-shadow-color: var(--bs-it-tertiary);">
						<img src="{{ $a->getPoster("url") }}" alt="{{ $a->getPoster("filename") }}" class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur text-center text-lg-start">
							<h5 class="card-title display-6">{{ Str::limit(Str::title($a->title), 25) }}</h5>
							<p class="card-text">{{ Str::limit($a->content, 125) }}</p>
						</div>
					</a>
				</article>
				@empty
				{{-- No Announcement --}}
				<div class="col w-100">
					<div class="card text-bg-dark">
						<img src="{{ asset("uploads/announcements/default.png") }}" alt="Announcement's default background image." class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
							<i class="far fa-folder-open fa-2x"></i>
							<h3 class="card-title m-0">No Announcement Yet...</h3>
						</div>
					</div>
				</div>
				@endforelse
			</div>
		</div>

		<div class="card-footer footer-center footer-lg-end bg-transparent border-0 text-center text-lg-end transition-3">
			<a href="{{ route('announcements.index') }}" class="link-body-emphasis fs-5 fw-normal">See More...</a>
		</div>
	</section>

	{{-- LOST & FOUND --}}
	<section class="card floating-header floating-footer no-inner-buffer bg-transparent border-0 my-10">
		<h2 class="card-header header-center header-lg-start bg-transparent border-0 display-4 text-center text-lg-start transition-3">Lost & Found</h2>

		<div class="card-body">
			<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 gx-0 gy-3 gx-md-3">
				{{-- Lost Items --}}
				@forelse($lostItems as $l)
				<article class="col">
					<a href="{{ route("lost-and-found.show", ["id" => $l->id]) }}" class="card text-bg-dark clickable">
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
					</a>
				</article>
				@empty
				{{-- No Lost Item(s) --}}
				<div class="col w-100">
					<div class="card text-bg-dark">
						<img src="{{ asset("uploads/lost-and-found/default.png") }}" alt="Lost and Found's default background image." class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
							<i class="fas fa-box-open fa-3x"></i>
							<h3 class="card-title m-0">No Lost Items</h3>
						</div>
					</div>
				</div>
				@endforelse
			</div>
		</div>

		<div class="card-footer footer-center footer-lg-end bg-transparent border-0 text-center text-lg-end transition-3">
			<a href="{{ route('lost-and-found.index') }}" class="link-body-emphasis fs-5 fw-normal">See More...</a>
		</div>
	</section>

	{{-- POPULAR DISCUSSIONS --}}
	<section class="card floating-header floating-footer no-inner-buffer bg-transparent border-0 my-10">
		<h2 class="card-header header-center header-lg-start bg-transparent border-0 display-4 text-center text-lg-start transition-3">Popular Discussions</h2>

		<div class="card-body">
			<div class="row flex-wrap row-gap-3">
				@forelse ($discussions as $category => $items)
				<article class="col-12 col-lg-6">
					<div class="card h-100">
						<h3 class="card-header bg-it-primary text-light fw-normal transition-3">{{ ucwords($category) }}</h3>

						<div class="card-body p-0">
							<div class="list-group list-group-flush border-bottom">
								@foreach ($items as $item)
								<a href="@{{ route('discussions.show', [$item->id]) }}" class="list-group-item list-group-item-action fw-normal fs-4">
									{{ Str::limit($item->title, 25) }}
								</a>
								@endforeach
							</div>
						</div>
					</div>
				</article>
				@empty
				{{-- No Discussion --}}
				<div class="col w-100">
					<div class="card text-bg-dark">
						<img src="{{ asset("uploads/discussions/default.png") }}" alt="Lost and Found's default background image." class="card-img brightness-1">
						<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
							<i class="fas fa-comments fa-3x"></i>
							<h3 class="card-title m-0">No Discussions Yet...</h3>
						</div>
					</div>
				</div>
				@endforelse
			</div>
		</div>

		<div class="card-footer footer-center footer-lg-end bg-transparent border-0 text-center text-lg-end transition-3">
			<a href="#" class="link-body-emphasis fs-5 fw-normal">See More...</a>
		</div>
	</section>
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
