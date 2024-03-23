<nav class="d-flex justify-items-center justify-content-between">
	<div class="flex-fill d-flex flex-column flex-sm-row align-items-center justify-content-between">
		<div>
			<p class="small text-muted">
				{!! __('Showing') !!}
				<span class="fw-semibold">{{ $paginator->firstItem() }}</span>
				{!! __('to') !!}
				<span class="fw-semibold">{{ $paginator->lastItem() }}</span>
				{!! __('of') !!}
				<span class="fw-semibold">{{ $paginator->total() }}</span>
				{!! __('results') !!}
			</p>
		</div>

		<div>
			<ul class="pagination pagination-sm">
				{{-- Previous Page Link --}}
				@if ($paginator->onFirstPage())
					{{-- FIRST PAGE --}}
					<li class="page-item disabled" aria-disabled="true" aria-label="Go to the first page">
						<span class="page-link" aria-hidden="true">
							<i class="fas fa-backward"></i>
						</span>
					</li>

					{{-- PREV --}}
					<li class="page-item disabled" aria-disabled="true" aria-label="Go to previous page">
						<span class="page-link" aria-hidden="true">
							<i class="fas fa-caret-left"></i>
						</span>
					</li>
				@else
					{{-- FIRST PAGE --}}
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->toArray()["first_page_url"] }}" rel="prev" aria-label="Go to the first page">
							<i class="fas fa-backward"></i>
						</a>
					</li>

					{{-- PREV --}}
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Go to previous page">
							<i class="fas fa-caret-left"></i>
						</a>
					</li>
				@endif

				{{-- Pagination Elements --}}
				@foreach ($elements as $element)
					{{-- "Three Dots" Separator --}}
					@if (is_string($element))
						<li class="page-item">
							<span class="page-link"
								data-paginator-ellipsis
								data-paginator-min="1"
								data-paginator-max="{{ $paginator->lastPage() }}"
								data-paginator-url="{{ $paginator->url(1) }}">{{ $element }}</span>
						</li>
					@endif

					{{-- Array Of Links --}}
					@if (is_array($element))
						@foreach ($element as $page => $url)
							@if ($page == $paginator->currentPage())
								<li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
							@else
								<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
							@endif
						@endforeach
					@endif
				@endforeach

				{{-- Next Page Link --}}
				@if ($paginator->hasMorePages())
					{{-- NEXT PAGE --}}
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Go to next page">
							<i class="fas fa-caret-right"></i>
						</a>
					</li>

					{{-- LAST PAGE --}}
					<li class="page-item">
						<a class="page-link" href="{{ $paginator->toArray()["last_page_url"] }}" rel="next" aria-label="Go to the last page">
							<i class="fas fa-forward"></i>
						</a>
					</li>
				@else
					{{-- NEXT PAGE --}}
					<li class="page-item disabled" aria-disabled="true" aria-label="Go to next page">
						<span class="page-link" aria-hidden="true">
							<i class="fas fa-caret-right"></i>
						</span>
					</li>

					{{-- LAST PAGE --}}
					<li class="page-item disabled" aria-disabled="true" aria-label="Go to the last page">
						<span class="page-link" aria-hidden="true">
							<i class="fas fa-forward"></i>
						</span>
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>

@push('scripts')
<script type="text/javascript" src="{{ mix('js/widget/paginator-widget.js') }}"></script>
@endpush
