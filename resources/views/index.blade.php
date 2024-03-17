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
		<h2 class="card-header bg-transparent border-0 display-4">Announcements</h2>

		<div class="card-body">
			<div class="row row-cols-1 row-cols-lg-2 gx-0 gy-3 gx-lg-3">
				{{-- Announcement Items --}}
				@forelse($announcements as $a)
				<article class="col">
					<div class="card text-bg-dark clickable">
						<img src="{{ asset("uploads/carousel/carousel-4.jpg") }}" alt="" class="card-img brightness-2">
						<div class="card-img-overlay text-center text-lg-start backdrop-blur-1">
							{{-- <h5 class="card-title display-6">{{ Str::limit(Str::title($a->title), 25) }}</h5>
							<p class="card-text">{{ Str::limit($a->content, 125) }}</p> --}}
							<h5 class="card-title display-6">{{ Str::limit(Str::title($a), 25) }}</h5>
							<p class="card-text">{{ Str::limit($a, 125) }}</p>
						</div>
					</div>
				</article>
				@empty
				{{-- No Announcement --}}
				<div class="col w-100">
					<div class="card bg-transparent border-0">
						<div class="card-body card-title text-center h3 m-0">No Announcement Yet...</div>
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
