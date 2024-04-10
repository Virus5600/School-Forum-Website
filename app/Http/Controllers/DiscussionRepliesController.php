<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Discussion;
use App\Models\DiscussionReplies;

use Carbon;
use DB;
use Exception;
use Log;
use Validator;

class DiscussionRepliesController extends Controller
{
    public function store(Request $req, string $name, string $slug) {
		$validator = Validator::make(
			$req->except('_token'),
			DiscussionReplies::getValidationRules(),
			DiscussionReplies::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator)
				->withInput()
				->withFragment('comment-form');
		}

		$cleanData = (object) $validator->validated();

		try {
			DB::beginTransaction();

			$discussion = Discussion::where('slug','=', $slug)
				->first();

			$comment = $discussion->comments()
				->create([
					'content' => $cleanData->content,
					'replied_by' => auth()->id(),
				]);

			// Fetch the last page of the comments
			$lastPage = (int) ceil($discussion->comments()->count() / 10);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->with('flash_error', 'An error occurred while trying to save your comment. Please try again later.');
		}

		return redirect()
			->route('discussions.show', ['name' => $name, 'slug' => $slug, 'page' => $lastPage])
			->with('flash_success', 'Your comment has been successfully saved.')
			->withFragment(Carbon::parse($comment->created_at)->timestamp . $comment->id);
	}

	public function edit(Request $req, string $name, string $slug, int $id) {
		$comment = DiscussionReplies::where('id', $id)
			->with('repliedBy')
			->firstOrFail();

		return view('discussions.comments.edit', [
			'page' => $req->page ?? null,
			'comment' => $comment,
			'name' => $name,
			'slug' => $slug,
		]);
	}

	public function update(Request $req, string $name, string $slug, int $id) {
		$validator = Validator::make(
			$req->except(['_token', '_method']),
			DiscussionReplies::getValidationRules(),
			DiscussionReplies::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator)
				->withInput();
		}

		$cleanData = (object) $validator->validated();

		try {
			DB::beginTransaction();

			$comment = DiscussionReplies::find($id);

			$comment->update([
				'content' => $cleanData->content,
			]);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->with('flash_error', 'An error occurred while trying to update your reply. Please try again later.');
		}

		$params = [
			'name' => $name,
			'slug' => $slug,
		];

		if ($req->has('page')) {
			$params['page'] = $req->page;
		}

		return redirect()
			->route('discussions.show', $params)
			->with('flash_success', 'Your reply has been successfully updated.')
			->withFragment(Carbon::parse($comment->created_at)->timestamp . $comment->id);
	}

	public function delete(Request $req, string $name, string $slug, int $id) {
		$comment = DiscussionReplies::findOrFail($id);

		try {
			DB::beginTransaction();

			$comment->delete();

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->with('flash_error', 'An error occurred while trying to delete your reply. Please try again later.');
		}

		return redirect()
			->route('discussions.show', ['name' => $name, 'slug' => $slug])
			->with('flash_success', 'Your reply has been successfully deleted.');
	}
}
