@extends('layouts.public')

@section('title', 'Announcements - ' . $announcement->title)

@section('content')
<div class="container-fluid body-container">
	{{-- BREADCRUMBS --}}
	{{ Breadcrumbs::render() }}

	<hr>

	<div class="row position-relative">
		{{-- CONTENTS --}}
		<article class="col-12 col-sm-9 d-flex flex-column row-gap-3 row-gap-sm-5">
			{{-- HERO CONTENT --}}
			<hgroup class="d-flex flex-column row-gap-3 text-center">
				<h1 class="m-0 p-2 display-1">{{ $announcement->title }}</h1>

				<img src="{{ $announcement->getPoster("url") }}"
					alt="{{ $announcement->getPoster("filename") }}"
					class="rounded mx-auto w-100 w-sm-50"
					draggable="false">
			</hgroup>

			<section class="card card-body text-bg-it-secondary border-0">
				{!!
				Str::of($announcement->content)->markdown([
					'html' => "strip"
				])
				!!}
			</section>
		</article>

		{{-- OTHER ANNOUNCEMENTS --}}
		<aside class="col-3 d-none d-lg-block">
			<div class="card card-body bg-it-quaternary sticky-top" style="top: calc(var(--navbar-height) * 1.25);">
				<h2 class="h3">Other Announcements</h2>

				<div class="d-flex flex-column row-gap-3">
					{{-- Actual items --}}
					@forelse ($otherAnnouncements as $a)
					<a href="{{ route("announcements.show", ["slug" => $a->slug]) }}" class="card text-bg-dark clickable" style="--bs-hoverable-shadow-color: var(--bs-it-tertiary);">
						<img src="{{ $a->getPoster("url") }}" alt="{{ $a->getPoster("filename") }}" class="card-img brightness-1">

						<div class="card-img-overlay has-backdrop-blur d-flex flex-column text-center justify-content-center align-items-center">
							<h5 class="card-title">{{ Str::title($a->title) }}</h5>
						</div>
					</a>
					@empty
					{{-- No Announcement --}}
					<div class="card text-bg-dark">
						<img src="{{ asset("uploads/announcements/default.png") }}" alt="Announcement's default background image." class="card-img brightness-1">

						<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
							<i class="far fa-folder-open fa-2x"></i>
							<h3 class="card-title m-0 text-center">No Announcement Yet...</h3>
						</div>
					</div>
					@endforelse
				</div>
			</div>
		</aside>
	</div>
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
