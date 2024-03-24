@extends('layouts.public')

@section('title', 'Lost & Found')

@section('content')
<div class="container-fluid body-container">
	{{ Breadcrumbs::render() }}
	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Lost & Found</h1>
	</hgroup>

	{{-- INSTRUCTIONS --}}
	<section class="card floating-header mb-3 p-0 text-light alert alert-dismissible fade show" role="alert">
		<div class="card-header border rounded bg-it-secondary border-it-primary z-1">
			<h2 class="m-0">Attention</h2>
		</div>

		<div class="card-body border rounded bg-it-secondary border-it-primary position-relative z-0">
			{{-- Close Button --}}
			<button type="button" class="btn-close m-2 p-0 fs-md" aria-label="Close" data-bs-dismiss="alert"></button>

			{{-- Content --}}
			<div class="d-flex column-gap-3">
				<div class="w-auto">
					<i class="fa-solid fa-circle-exclamation fa-3x mb-3"></i>
				</div>

				<div class="w-auto d-flex flex-column justify-content-center align-items-center">
					{!! Str::of($instructions)->markdown() !!}
				</div>
			</div>
		</div>
	</section>

	{{-- TOP PAGINATOR --}}
	{{ $lostItems->onEachSide(-1)->links() }}

	{{-- LOST ITEMS --}}
	<section class="row row-cols-1 row-cols-md-3 gx-0 gy-3 gx-md-3 mb-3">
		{{-- Lost Items "items" --}}
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
	</section>

	{{-- BOT PAGINATOR --}}
	{{ $lostItems->onEachSide(-1)->links() }}
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
