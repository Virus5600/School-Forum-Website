@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Discussion Categories')

@section('content')
<div class="container-fluid body-container">
	<div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
		<div class="d-flex flex-column flex-lg-row justify-content-start align-items-center gap-3">
			<a href="{{ route('discussions.index') }}" class="link-body-emphasis icon-link icon-link-hover text-decoration-none" style="--bs-icon-link-transform: translateX(-.25rem);">
				<i class="fas fa-chevron-left bi"></i>
				Go back to Discussions
			</a>

			<div class="vr"></div>

			{{ Breadcrumbs::render() }}
		</div>

		<a href="{{ route('discussions.create', ["url" => url()->full()]) }}" class="btn btn-it-primary icon-link icon-link-hover" title="Start your own discussion." style="--bs-icon-link-transform: scale(1.125);">
			<i class="fas fa-comments bi"></i>
			Start your own discussion
		</a>
	</div>

	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Categories</h1>
	</hgroup>

	<div class="row justify-content-center row-gap-3">
		{{-- QUERIES --}}
		<div class="col-12 col-lg-4">
			<div class="card">
				<div class="card-body vstack row-gap-3">
					<form action="{{ route('discussions.categories.index') }}" method="GET">
						@foreach (request()->except(["_token", "search", "sort", "direction"]) as $k => $v)
						<input type="hidden" name="{{ $k }}" value="{{ $v }}">
						@endforeach

						<x-search search="{{ $search }}" />
					</form>

					<a href="{{ route('discussions.categories.index') }}" class="btn btn-it-primary btn-sm">Reset Filter(s)</a>
				</div>
			</div>
		</div>

		{{-- CATEGORIES --}}
		<div class="col-12 col-lg-8">
			<div class="card">
				<div class="card-body table-responsive">
					<table class="table table-striped table-hover table-sm" id="category_table">
						<thead>
							<tr>
								<th class="text-start text-nowrap w-100" scope="col">
									@sortablelink('name', 'Category')
								</th>

								<th class="text-end text-nowrap" scope="col">
									@sortablelink('discussions_count', 'Discussions')
								</th>
							</tr>
						</thead>

						<tbody>
							@forelse($categories as $value)
								@if (!$value->discussions->isEmpty())
								<tr>
									<td class="text-start">
										<a href="{{ route('discussions.categories.show', [$value->name]) }}" class="link-body-emphasis text-decoration-none icon-link icon-link-hover w-100" title="See disucssions under {{ ucwords($value->name) }}." style="--bs-icon-link-transform: translate3d(0, -.25rem, 0);">
											<i class="fas fa-up-right-from-square bi transition-2"></i>
											{{ ucwords($value->name) }}
										</a>
									</td>

									<td class="text-end">
										<small class="text-muted">
											<i class="fas fa-comments"></i>
											{{ $value->discussions_count }}
										</small>
									</td>
								</tr>
								@endif
							@empty
							<td colspan="2">
								<div class="card text-bg-dark">
									<img src="{{ asset("uploads/discussions/default.png") }}" alt="Lost and Found's default background image." class="card-img brightness-1">
									<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
										<i class="fas fa-box-open fa-3x"></i>
										<h3 class="card-title m-0">No Discussions Yet...</h3>
									</div>
								</div>
							</td>
							@endforelse
						</tbody>
					</table>
				</div>

				<div class="card-footer">
					{{ $categories->onEachSide(-1)->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush

@push('scripts')
<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
@endpush
