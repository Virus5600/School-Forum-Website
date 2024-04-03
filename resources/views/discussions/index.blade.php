@extends('layouts.public')

@section('title', 'Lost & Found')

@section('content')
<div class="container-fluid body-container">
	{{ Breadcrumbs::render() }}
	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Discussions</h1>
	</hgroup>

	{{-- TOP PAGINATOR --}}
	{{ $discussions->onEachSide(-1)->links() }}

	{{-- DISCUSSIONS --}}
	<div class="row row-cols-1 {{ request()->has('category') ? '' : 'row-cols-lg-2' }} row-gap-3">
		@forelse($discussions as $value)
			@if (!$value->discussions->isEmpty())
			<section class="card bg-transparent border-0 {{ $value->name == 'general' ? 'order-first' : '' }}">
				<h2 class="card-header bg-it-primary text-light fw-normal transition-3">
					{{ ucwords($value->name) }}
				</h2>

				<div class="card-body bg-light p-0">
					<div class="list-group list-group-flush border-bottom transition-3">
						@foreach ($value->discussions->splice(0, 5) as $d)
						<div class="hstack justify-content-between list-group-item list-group-item-action">
							<a href="@{{ route('discussions.show', $d->id) }}" class="fw-normal fs-6 text-wrap">
								{{ Str::limit($d->title, 25) }}
							</a>

							<div class="d-flex justify-content-between align-items-center" style="width: 250px;">
								<small class="text-muted">
									<i class="fas fa-user"></i>
									{{ $d->postedBy->username }}
								</small>

								<small class="text-muted">
									{{ $d->created_at->diffForHumans() }}
								</small>
							</div>
						</div>
						@endforeach
					</div>
				</div>

				<div class="card-footer bg-it-secondary text-center">
					<a href="" class="link-body-emphasis" data-bs-theme="dark">See More...</a>
				</div>
			</section>
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
	</div>

	{{-- BOT PAGINATOR --}}
	{{ $discussions->onEachSide(-1)->links() }}
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
