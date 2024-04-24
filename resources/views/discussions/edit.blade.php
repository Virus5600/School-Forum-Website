@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Discussions - Edit ' . $discussion->title)

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
	<form action="{{ route('discussions.update', [$discussion->category->slug, $discussion->slug]) }}" class="card my-5" method="POST" enctype="multipart/form-data">
		@csrf
		@method('PATCH')

		{{-- HEADER --}}
		<h2 class="card-header d-flex flex-row justify-content-between">
			{{-- Author --}}
			<div class="m-0 p-0 fw-normal h5">
				<a href="javascript:void(0);" class="text-body-emphasis link-offset-1 icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);">
					<img src="{{ $discussion->postedBy->getAvatar('url') }}" alt="{{ $discussion->postedBy->username }}" class="rounded-circle border bi" style="width: 32px !important; height: 32px !important;">
					By {{ $discussion->postedBy->username }}
				</a>
			</div>

			{{-- Date --}}
			<div class="m-0 p-0 fw-normal h6 d-flex align-items-center">
				{{ $discussion->created_at->format('F j, Y (h:i A)') }}
			</div>
		</h2>

		{{-- BODY --}}
		<div class="card-body">
			{{-- Title --}}
			<div class="form-group my-3">
				<label for="title" class="form-label required-after">Title</label>

				<input type="text" name="title" id="title" class="form-control {{ $errors->count() > 0 ? ($errors->has('title') ? 'is-invalid' : 'is-valid') : '' }}" value="{{ $discussion->title }}" required>

				<x-forms.validation-error field="title" />
			</div>

			{{-- Content --}}
			<div class="form-group my-3">
				{{-- Label --}}
				<label for="content" class="form-label required-after">Content</label>

				{{-- Editor - Content --}}
				<div id="editor" class="h-100 p-0 form-control {{ $errors->count() > 0 ? ($errors->has('content') ? 'is-invalid' : 'is-valid') : '' }}"
					data-ui-placeholder="Start a Discussion..."
					>
					{!! nl2br($discussion->content) !!}
				</div>

				{{-- Actual Input --}}
				<textarea name="content" id="content-input" class="visually-hidden" required>{!! nl2br($discussion->content) !!}</textarea>

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
				<button class="btn btn-it-secondary text-light" data-cl-leave data-cl-leave-href="{{ route('discussions.show', [$discussion->category->slug, $discussion->slug]) }}">Cancel</button>
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
