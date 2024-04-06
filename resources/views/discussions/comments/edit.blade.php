@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Discussions - Edit Comment')

@section('content')
<div class="container-fluid body-container">
	{{ Breadcrumbs::render() }}
	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-0 display-1">
			Edit Comment
		</h1>
	</hgroup>

	{{-- FORM --}}
	<form action="{{ route('discussions.comments.update', [$name, $slug, $comment->id]) }}" class="card my-5" method="POST" enctype="multipart/form-data">
		@csrf
		@method('PATCH')

		{{-- HEADER --}}
		<h2 class="card-header d-flex flex-row justify-content-between">
			{{-- Author --}}
			<div class="m-0 p-0 fw-normal h5">
				<a href="javascript:void(0);" class="text-body-emphasis link-offset-1 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
					<img src="{{ $comment->repliedBy->getAvatar('url') }}" alt="{{ $comment->repliedBy->username }}" class="rounded-circle border bi" style="width: 32px !important; height: 32px !important;">
					By {{ $comment->repliedBy->username }}
				</a>
			</div>

			{{-- Date --}}
			<div class="m-0 p-0 fw-normal h6 d-flex align-items-center">
				{{ $comment->created_at->format('F j, Y (h:i A)') }}
			</div>
		</h2>

		{{-- BODY --}}
		<div class="card-body">
			<div class="form-group">
				{{-- Label --}}
				<label for="content" class="form-label visually-hidden">Edit Comment</label>

				{{-- Editor --}}
				<div id="editor" class="h-100 p-0 form-control {{ $errors->count() > 0 ? ($errors->has('content') ? 'is-invalid' : 'is-valid') : '' }}"
					data-ui-placeholder="Reply to this discussion..."
					>
					{!! nl2br($comment->content) !!}
				</div>

				{{-- Actual Input --}}
				<textarea name="content" id="content-input" class="visually-hidden" required>{!! nl2br($comment->content) !!}</textarea>

				{{-- Error Message --}}
				<x-forms.validation-error field="content" />
			</div>
		</div>

		{{-- FOOTER --}}
		<div class="card-footer">
			<div class="hstack justify-content-end column-gap-3">
				{{-- SUBMIT --}}
				<button type="submit" class="btn btn-it-primary" data-dos-action="update">Update</button>

				{{-- CANCEL --}}
				<button class="btn btn-it-secondary text-light" data-cl-leave data-cl-leave-href="{{ route('discussions.show', [$name, $slug]) }}">Cancel</button>
			</div>
		</div>
	</form>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ mix('views/discussions/show-text-editor.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/util/confirm-leave.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
@endpush
