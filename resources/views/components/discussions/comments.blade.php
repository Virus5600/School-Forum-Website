@props(['comment', 'additionalClass' => '', 'discussion', 'name', 'slug', 'page' => 0])

@php
$params = [$name, $slug, $comment->id];

if ($page > 0 && is_int($page)) {
	$params['page'] = $page;
}
@endphp

<ul class="list-group {{ $additionalClass }} border-0" id="{{ Carbon::parse($comment->created_at)->timestamp . $comment->id }}">
	{{-- COMMENT INFORMATION --}}
	<li class="list-group-item d-flex justify-content-between border-bottom-0 border-top-0 border-end-0 border-bottom-0 border-start-1">
		{{-- COMMENTS AUTHOR --}}
		<a href="javascript:void(0);" class="text-body-emphasis link-offset-1 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
			<img src="{{ $comment->repliedBy->getAvatar('url') }}" alt="{{ $comment->repliedBy->username }}" class="rounded-circle border bi" style="width: 32px !important; height: 32px !important;">
			{{ $comment->repliedBy->username }}
		</a>

		{{-- COMMENTS DATE --}}
		<div class="hstack column-gap-3">
			@if ($comment->updated_at->gt($comment->created_at))
				<span class="badge rounded-pill bg-it-secondary text-light">
					Edited
				</span>
			@endif

			<time datetime="{{ $comment->created_at->format('Y-m-d\TH:i:s') }}" class="text-muted">
				{{ $comment->created_at->diffForHumans() }}
			</time>

			@auth
				@if (auth()->user()->id === $comment->replied_by)
					<div class="dropdown">
						{{-- DROPDOWN BUTTON --}}
						<button class="btn btn-sm btn-light text-body-emphasis" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-ellipsis-vertical"></i>
						</button>

						<div class="dropdown-menu drop-down-menu-end" aria-label="More actions...">
							{{-- EDIT --}}
							<a class="dropdown-item" href="{{ route('discussions.comments.edit', $params) }}">
								Edit
							</a>

							{{-- DELETE --}}
							<form action="@{{ route('discussions.comments.delete', $params) }}" method="POST">
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

	{{-- COMMENT CONTENT --}}
	<li class="list-group-item border-top-0 border-end-0 border-bottom-0 border-start-1">
		{!!
			Str::markdown($comment->content, [
				"html_input" => "strip"
			])
		!!}
	</li>

	{{-- COMMENT ACTIONS --}}
	@auth
	@php ($likes = rand(-100, 100))
	<li class="list-group-item d-flex flex-row justify-content-between border-top-0 border-end-0 border-bottom-0 border-start-1">
		<div class="btn-group" role="group" aria-label="Reply Actions">
			{{-- UPVOTE --}}
			<button type="button" class="btn btn-sm icon-link icon-link-hover border-0 upvote" style="--bs-icon-link-transform: translateY(-.25rem);">
				<i class="fas fa-caret-up bi"></i>
				{{ $likes }}
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
			Reply
		</button>
	</li>
	@endauth
</ul>
