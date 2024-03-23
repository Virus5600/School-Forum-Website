@extends('layouts.public')

@section('title', 'Announcements')

@section('content')
<div class="container-fluid body-container bg-it-quaternary">
	{{ Breadcrumbs::render() }}
	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Announcements</h1>
	</hgroup>

	{{-- TOP PAGINATOR --}}
	{{ $announcements->onEachSide(-1)->links() }}

	{{-- ANNOUNCEMENTS --}}
	<section class="row row-cols-1 row-cols-lg-2 gx-0 gy-3 gx-lg-3 mb-3">
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
	</section>

	{{-- BOT PAGINATOR --}}
	{{ $announcements->onEachSide(-1)->links() }}
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
