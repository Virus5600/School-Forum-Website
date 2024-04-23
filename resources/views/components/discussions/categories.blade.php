@props(['value'])

<section class="card bg-transparent border-0 {{ $value->name == 'general' ? 'order-first' : '' }}">
	<h2 class="card-header bg-it-primary text-light fw-normal transition-3">
		{{ ucwords($value->name) }}
	</h2>

	<div class="card-body bg-light p-0 table-responsive">
		<table class="table table-striped table-hover my-0 align-middle text-nowrap">
			<tbody>
				@foreach ($value->discussions->splice(0, 5) as $d)
				<tr>
					<td>
						<a href="{{ route('discussions.show', [$value->name, $d->slug]) }}" class="fw-normal fs-6">
							{{ Str::limit($d->title, 25) }}
						</a>
					</td>

					<td class="text-muted small">
						<i class="fas fa-user"></i>
						{{ $d->postedBy->trashed() ? '[Deleted User]' : $d->postedBy->username }}
					</td>

					<td class="text-muted small">
						<i class="fas fa-calendar-days"></i>
						{{ $d->created_at->diffForHumans() }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="card-footer bg-it-secondary text-center">
		<a href="{{ route('discussions.categories.show', [$value->name]) }}" class="link-body-emphasis" data-bs-theme="dark">See More...</a>
	</div>
</section>
