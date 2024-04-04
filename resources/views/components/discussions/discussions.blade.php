@props(['value', 'category'])

<section class="card bg-transparent border-0 {{ $category == 'general' ? 'order-first' : '' }}">
	<h2 class="card-header bg-it-primary text-light fw-normal transition-3">
		{{ ucwords($category) }}
	</h2>

	<div class="card-body bg-light p-0">
		<div class="list-group list-group-flush border-bottom transition-3">
			@foreach ($value as $d)
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
</section>
