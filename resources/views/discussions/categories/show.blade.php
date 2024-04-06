@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Discussions - ' . ucwords($category->name) . ' Category')

@section('content')
<div class="container-fluid body-container">
	{{ Breadcrumbs::render() }}
	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">{{ ucwords($category->name) }}</h1>
	</hgroup>

	<div class="row justify-content-center">
		{{-- QUERIES --}}
		<div class="col-12 col-lg-4">
			<div class="card">
				<div class="card-body vstack row-gap-3">
					<form action="{{ route('discussions.categories.show', [$category->name]) }}" method="GET">
						@foreach (request()->except(["_token", "search", "sort", "direction"]) as $k => $v)
						<input type="hidden" name="{{ $k }}" value="{{ $v }}">
						@endforeach

						<x-search search="{{ $search }}" />
					</form>

					<a href="{{ route('discussions.categories.show', [$category->name]) }}" class="btn btn-it-primary btn-sm">Reset Filter(s)</a>
				</div>
			</div>
		</div>

		{{-- CATEGORIES --}}
		<div class="col-12 col-lg-8">
			<div class="card">
				<div class="card-body">
					<table class="table table-striped table-hover table-sm" id="category_table">
						<thead>
							<tr>
								<th class="text-start text-nowrap w-75" scope="col">
									@sortablelink('discussions.title', 'Title')
								</th>

								<th class="text-start text-nowrap" scope="col">
									@sortablelink('postedBy.username', 'Posted By')
								</th>

								<th class="text-start text-nowrap" scope="col">
									@sortablelink('discussions.created_at', 'Posted On')
								</th>
							</tr>
						</thead>

						<tbody>
							@forelse($discussions as $d)
							<tr>
								<td class="text-start">
									<a href="{{ route('discussions.show', [$category->name, $d->slug]) }}" class="link-body-emphasis text-decoration-none icon-link icon-link-hover w-100" title="{{ ucwords($d->title) }}." style="--bs-icon-link-transform: translate3d(0, -.25rem, 0);">
										<i class="fas fa-up-right-from-square bi transition-2"></i>
										{{ ucwords($d->title) }}
									</a>
								</td>

								<td class="text-start text-nowrap">
									<a href="{{ request()->fullUrlWithQuery(["user" => $d->postedBy->username]) }}" class="small text-muted icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.25);">
										<i class="fas fa-user bi"></i>
										{{ $d->postedBy->username }}
									</a>
								</td>

								<td class="text-start text-nowrap">
									<small class="text-muted">
										<i class="fas fa-calendar"></i>
										{{ $d->created_at->diffForHumans() }}
									</small>
								</td>
							</tr>
							@empty
							<td colspan="3">
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
					{{ $discussions->onEachSide(-1)->links() }}
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

