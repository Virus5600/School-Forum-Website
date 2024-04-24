@extends('layouts.public')

@section('title', 'Lost & Found')

@section('content')
<div class="container-fluid body-container">
	<div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
		{{ Breadcrumbs::render() }}

		<a href="{{ route('discussions.create') }}" class="btn btn-it-primary icon-link icon-link-hover" title="Start your own discussion." style="--bs-icon-link-transform: scale(1.125);">
			<i class="fas fa-comments bi"></i>
			Start your own discussion
		</a>
	</div>

	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h2 class="m-0 p-2 display-1">Discussion Categories</h2>
	</hgroup>

	{{-- CATEGORIES --}}
	<section class="card floating-footer border-0 bg-transparent mb-6">
		<div class="card-body bg-transparent">
			<div class="row gap-3 justify-content-center align-items-center">
				@forelse ($categories as $c)
					<a href="{{ route('discussions.categories.show', [$c->slug]) }}" class="link-body-emphasis text-decoration-none badge rounded-pill text-bg-danger bg-it-primary fs-6 w-75 w-lg-25 p-3 d-flex justify-content-between transition-3" data-bs-theme="dark" title="See disucssions under {{ ucwords($c->name) }}.">
						<div>
							<i class="fas fa-up-right-from-square"></i>
							{{ ucwords($c->name) }}
						</div>

						<small class="text-light" title="{{ $c->discussions_count }} ongoing discussion.">
							<i class="fas fa-comments"></i>
							{{ $c->discussions_count }}
						</small>
					</a>
				@empty
				@endforelse
			</div>
		</div>

		<div class="card-footer footer-center bg-transparent text-center border-0">
			<a href="{{ route('discussions.categories.index') }}" class="link-body-emphasis">See More...</a>
		</div>
	</section>

	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Discussions</h1>
	</hgroup>

	{{-- TOP PAGINATOR --}}
	{{ $discussions->onEachSide(-1)->links() }}

	{{-- DISCUSSIONS --}}
	<section class="row row-cols-1 row-cols-lg-2 row-gap-3 my-3">
		@forelse($discussions as $value)
			@if (!$value->discussions->isEmpty())
			<x-discussions.categories :value="$value"/>
			@endif
		@empty
		<div class="col w-100">
			<div class="card text-bg-dark">
				<img src="{{ asset("uploads/discussions/default.png") }}" alt="Lost and Found's default background image." class="card-img brightness-1">
				<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
					<i class="fas fa-box-open fa-3x"></i>
					<h3 class="card-title m-0">No Discussions Yet...</h3>
				</div>
			</div>
		</div>
		@endforelse
	</section>

	{{-- BOT PAGINATOR --}}
	{{ $discussions->onEachSide(-1)->links() }}

	<hr>
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
