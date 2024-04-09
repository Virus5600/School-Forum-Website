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
	@php
	$action = $comment->getStatusAction(auth()->user()->id);
	$upvoteAction = $action['upvote'];
	$downvoteAction = $action['downvote'];
	@endphp

	@auth
	<li class="list-group-item d-flex flex-row justify-content-between border-top-0 border-end-0 border-bottom-0 border-start-1">
		<div class="btn-group" role="group" aria-label="Reply Actions">
			{{-- UPVOTE --}}
			<button type="button" id="upvote-comment-{{ $comment->id }}" class="btn btn-sm icon-link icon-link-hover border border-start-0 rounded-start-pill upvote {{ $upvoteAction == 'unvote' ? 'active' : '' }}" style="--bs-icon-link-transform: translateY(-.25rem);" data-vote-id="{{ $comment->id }}" data-vote-route="{{ route('api.discussions.comments.upvote') }}" data-vote-action="{{ $upvoteAction }}">
				<i class="fas fa-up-long bi"></i>
				<span id="vote-count-comment-{{ $comment->id }}">{{ $comment->getVoteCount() }}</span>
			</button>

			{{-- DOWNVOTE --}}
			<button type="button" id="downvote-comment-{{ $comment->id }}" class="btn btn-sm icon-link icon-link-hover border border-end-0 rounded-end-pill downvote {{ $downvoteAction == 'unvote' ? 'active' : '' }}" style="--bs-icon-link-transform: translateY(.25rem);" data-vote-id="{{ $comment->id }}" data-vote-route="{{ route('api.discussions.comments.downvote') }}" data-vote-action="{{ $downvoteAction }}">
				<i class="fas fa-down-long bi"></i>
			</button>
		</div>

		{{-- REPLY --}}
		<a href="#comment-form" type="button" class="btn btn-sm border rounded-pill icon-link icon-link-hover" style="--bs-icon-link-transform: scale(-1.25, 1.25);">
			<i class="far fa-comment-dots fa-flip-horizontal bi"></i>
			Reply
		</a>
	</li>
	@endauth
</ul>
