@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Discussions - ' . $discussion->title)

@section('content')
<div class="container-fluid body-container">
	{{ Breadcrumbs::render() }}
	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-0 display-1">
			{{ ucwords($discussion->title) }}
		</h1>
	</hgroup>

	{{-- DISCUSSION --}}
	<div class="my-5 row justify-content-center">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<ul class="list-group border-0">
						{{-- DISCUSSION INFORMATION --}}
						<li class="list-group-item border-0 d-flex justify-content-between">
							{{-- DISCUSSION AUTHOR --}}
							<h2 class="m-0 p-0 fw-normal h5">
								<a href="javascript:void(0);" class="text-body-emphasis link-offset-1 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
									<img src="{{ $discussion->postedBy->getAvatar('url') }}" alt="{{ $discussion->postedBy->username }}" class="rounded-circle border bi" style="width: 32px !important; height: 32px !important;">
									By {{ $discussion->postedBy->username }}
								</a>
							</h2>

							{{-- DISCUSSION DATE --}}
							<div class="hstack column-gap-3">
								@if ($discussion->updated_at->gt($discussion->created_at))
									<span class="badge rounded-pill bg-it-secondary text-light">
										Edited
									</span>
								@endif

								<h3 class="m-0 p-0 fw-normal h6">
									{{ $discussion->created_at->format('F j, Y (h:i A)') }}
								</h3>

								@auth
									@if (auth()->user()->id === $discussion->posted_by)
										<div class="dropdown">
											{{-- DROPDOWN BUTTON --}}
											<button class="btn btn-sm btn-light text-body-emphasis" type="button" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="fas fa-ellipsis-vertical"></i>
											</button>

											<div class="dropdown-menu drop-down-menu-end" aria-label="More actions...">
												{{-- EDIT --}}
												<a class="dropdown-item" href="@{{ route('discussions.comments.edit', [$name, $discussion->slug]) }}">
													Edit
												</a>

												{{-- DELETE --}}
												<form action="@{{ route('discussions.comments.delete', [$name, $discussion->slug]) }}" method="POST">
													@csrf
													@method('DELETE')
													<button type="submit" class="dropdown-item">
														Delete
													</button>
												</form>
											</div>
										</div>
									@endif
								@endauth
							</div>
						</li>

						{{-- DISCUSSION CONTENT --}}
						<li class="list-group-item border-0">
							{!!
								Str::markdown($discussion->content, [
									"html_input" => "strip"
								])
							!!}
						</li>

						{{-- DISCUSSION ACTIONS --}}
						@auth
						<li class="list-group-item d-flex flex-row justify-content-between border-0">
							<div class="btn-group" role="group" aria-label="Comment Actions">
								{{-- UPVOTE --}}
								<button type="button" class="btn btn-sm icon-link icon-link-hover border-0 upvote" style="--bs-icon-link-transform: translateY(-.25rem);">
									<i class="fas fa-caret-up bi"></i>
									{{ rand(-100, 100) }}
								</button>

								{{-- DIVIDER --}}
								<div class="vr"></div>

								{{-- DOWNVOTE --}}
								<button type="button" class="btn btn-sm icon-link icon-link-hover border-0 downvote" style="--bs-icon-link-transform: translateY(.25rem);">
									<i class="fas fa-caret-down bi"></i>
								</button>
							</div>

							{{-- REPLY --}}
							<button type="button" class="btn btn-sm border-0 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(-1.125, 1.125);">
								<i class="far fa-comment-dots fa-flip-horizontal bi"></i>
								Comments {{ $discussion->comments_count > 0 ? $discussion->comments_count : "" }}
							</button>
						</li>
						@endauth
					</ul>
				</div>
			</div>
		</div>
	</div>

	<hr class="my-3">

	{{-- COMMENTS --}}
	@php(
		$comments = $discussion->comments()
			->orderBy('created_at', 'asc')
			->paginate(10)
			->fragment('content')
	)
	<div class="vstack row-gap-3">
		{{-- COMMENT ITEM --}}
		@forelse($comments as $reply)
			<x-discussions.comments :comment="$reply" additionalClass="my-3" name="{{ $discussion->category->name }}" slug="{{ $discussion->slug }}" :discussion="$discussion" page="{{ request()->page }}"/>
		@empty
			<div class="card card-body">
				<p class="m-0 p-0 text-center">
					No replies yet.
				</p>
			</div>
		@endforelse

		{{-- PAGINATION --}}
		{{ $comments->onEachSide(-1)->links() }}
	</div>

	{{-- COMMENT FORM --}}
	@auth
	<div class="card mt-5" id="form">
		<div class="card-body">
			<form action="{{ route('discussions.comments.store', [$discussion->category->name, $discussion->slug]) }}" method="POST">
				@csrf

				<div class="form-group">
					<label for="content" class="form-label visually-hidden">Reply</label>

					{{-- Editor --}}
					<div id="editor" class="h-100 p-0 form-control {{ $errors->count() > 0 ? ($errors->has('content') ? 'is-invalid' : 'is-valid') : '' }}"
						data-ui-placeholder="Reply to this discussion..."
						>
						{{ old('content') }}
					</div>

					{{-- Actual Input --}}
					<textarea name="content" id="content-input" class="visually-hidden" required>{{ old('content') }}</textarea>

					{{-- Error Message --}}
					<x-forms.validation-error field="content"/>
				</div>

				<div class="hstack justify-content-end mt-3">
					<button type="submit" class="btn btn-it-primary">Reply</button>
				</div>
			</form>
		</div>
	</div>
	@endauth
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ mix('views/discussions/show-text-editor.js') }}"></script>
@endpush
