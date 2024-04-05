@extends('layouts.public')

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

		<h2 class="m-0 p-0 fw-normal h5">
			<a href="javascript:void(0);" class="text-body-emphasis link-offset-1 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
				<img src="{{ $discussion->postedBy->getAvatar('url') }}" alt="{{ $discussion->postedBy->username }}" class="rounded-circle border bi" style="width: 32px !important; height: 32px !important;">
				By {{ $discussion->postedBy->username }}
			</a>
		</h2>

		<h3 class="m-0 p-0 fw-normal h6">
			Posted on {{ $discussion->created_at->format('F j, Y (h:i A)') }}
		</h3>
	</hgroup>

	<div class="mt-5 mt-lg-10 row justify-content-center">
		{{-- DISCUSSION --}}
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					{!!
						Str::markdown($discussion->content, [
							"html_input" => "strip"
						])
					!!}
				</div>
			</div>
		</div>
	</div>

	<hr>

	{{-- COMMENTS --}}
	<div class="vstack row-gap-3">
		@forelse($discussion->replies as $reply)
			<ul class="list-group">
				{{-- COMMENTS INFORMATION --}}
				<li class="list-group-item d-flex justify-content-between">
					{{-- COMMENTS AUTHOR --}}
					<a href="javascript:void(0);" class="text-body-emphasis link-offset-1 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
						<img src="{{ $reply->repliedBy->getAvatar('url') }}" alt="{{ $reply->repliedBy->username }}" class="rounded-circle border bi" style="width: 32px !important; height: 32px !important;">
						{{ $reply->repliedBy->username }}
					</a>

					{{-- COMMENTS DATE --}}
					<div class="hstack column-gap-3">
						@if ($reply->updated_at->gt($reply->created_at))
							<span class="badge rounded-pill bg-it-secondary text-light">
								Edited
							</span>
						@endif

						<time datetime="{{ $reply->created_at->format('Y-m-d\TH:i:s') }}" class="text-muted">
							{{ $reply->created_at->diffForHumans() }}
						</time>
					</div>
				</li>

				{{-- COMMENT CONTENT --}}
				<li class="list-group-item">
					{!!
						Str::markdown($reply->content, [
							"html_input" => "strip"
						])
					!!}
				</li>

				{{-- COMMENT ACTIONS --}}
				<li class="list-group-item">
					<div class="btn-group" role="group" aria-label="Comment Actions">
						{{-- LIKE --}}
						<button type="button" class="btn btn-outline-it-primary border-0 icon-link icon-link-hover" style="--bs-icon-link-transform: translateY(-.25rem);">
							<i class="fas fa-caret-up bi"></i>
							Upvote
						</button>

						{{-- DISLIKE --}}
						<button type="button" class="btn btn-outline-danger border-0 icon-link icon-link-hover" style="--bs-icon-link-transform: translateY(.25rem);">
							<i class="fas fa-caret-down bi"></i>
							Downvote
						</button>

						{{-- REPLY --}}
						<button type="button" class="btn btn-outline-secondary border-0 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
							<i class="fas fa-message bi"></i>
							Reply
						</button>
					</div>
				</li>

				<li class="list-group-item">
					{{-- REPLIES  --}}
					@if ($reply->replies->count() > 0)
						<ul class="list-group list-group-flush mt-3">
							@foreach($reply->replies as $subReply)
							<li class="list-group-item ms-5 px-0">
								{{-- SUB-COMMENTS INFORMATION --}}
								<div class="d-flex justify-content-between">
									{{-- SUB-COMMENTS AUTHOR --}}
									<a href="javascript:void(0);" class="text-body-emphasis link-offset-1 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
										<img src="{{ $subReply->repliedBy->getAvatar('url') }}" alt="{{ $subReply->repliedBy->username }}" class="rounded-circle border bi" style="width: 32px !important; height: 32px !important;">
										{{ $subReply->repliedBy->username }}
									</a>

									{{-- SUB-COMMENTS DATE --}}
									<div class="hstack column-gap-3">
										@if ($subReply->updated_at->gt($subReply->created_at))
											<span class="badge rounded-pill bg-it-secondary text-light">
												Edited
											</span>
										@endif

										<time datetime="{{ $subReply->created_at->format('Y-m-d\TH:i:s') }}" class="text-muted">
											{{ $subReply->created_at->diffForHumans() }}
										</time>
									</div>
								</div>

								{{-- SUB-COMMENTS CONTENT --}}
								{!!
									Str::markdown($subReply->content, [
										"html_input" => "strip"
									])
								!!}
							</li>
							@endforeach
						</ul>
					@endif
				</li>
			</ul>
		@empty
			<div class="card card-body">
				<p class="m-0 p-0 text-center">
					No replies yet.
				</p>
			</div>
		@endforelse
	</div>
</div>
@endsection
