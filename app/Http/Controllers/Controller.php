<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator as Validated;
use Intervention\Image\Image as IImage;

use App\Enums\EmailVerificationType;

use App\Jobs\AccountNotification;

use App\Models\User;

use Exception;
use Image;
use InvalidArgumentException;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

	const ADMIN_QUERY_PARAMS = ["search", "sort", "direction", "page"];
	const EXCEPT = ["_token", "_method", "search", "sort", "direction", "page"];

	/**
	 * Format the errors from the validator into a format that allows
	 * XHR requests to easily parse the errors.
	 *
	 * @param Validated $validator
	 * @return array
	 */
	protected function formatErrors(Validated $validator): array
    {
        $errors = $validator->errors()->getMessages();
        $obj = $validator->failed();
        $result = [];
        foreach($obj as $input => $rules){
            $i = 0;
            foreach($rules as $rule => $ruleInfo){
                $rule = $input.'['.strtolower($rule).']';
                $result[$rule] = $errors[$input][$i];
                $i++;
            }
        }
        return $result;
    }

	/**
	 * Include the parameters from the request that are in the list of
	 * parameter names.
	 *
	 * @param array $paramNames
	 * @return array
	 */
	protected function includeParams(array $paramNames, bool $handNonExistence = true): array
	{
		$params = [];
		foreach ($paramNames as $paramName)
			$params[$paramName] = request()->{$paramName} ?? ($handNonExistence ? "" : null);

		return $params;
	}

	/**
	 * Converts any image type into a WEBP image format.
	 *
	 * @param string $filename
	 * @param UploadedFile $image
	 * @param string $saveToPath
	 * @param int $quality
	 */
	protected function convertToWEBP(string $filename, UploadedFile $image, string $saveToPath, $quality = 75): IImage
	{
		// Handles the quality value. Max is 100.
		$quality = $quality > 100 ? 100 : ($quality < 0 ? 0 : $quality);

		$path = public_path("{$saveToPath}/{$filename}");

		$image = Image::make($image);
		$image->encode('webp', $quality)
			->save($path);

		return $image;
	}

	/**
	 * Creates a validator instance that will validates any up/downvote
	 * API request parameters. The `$type` parameter defines whether this
	 * is for a Discussion (`discussion`) or DiscussionReply (`comment`) model.
	 *
	 * @param string $type
	 * @param array $params
	 */
	protected function validateVoteParams(string $type, array $params): Validated
	{
		if (in_array($type, ['discussion', 'comment'])) {
			$table = $type === 'comment' ? "discussion_replies" : "{$type}s";
			$type = ucwords($type);
		}
		else {
			throw new InvalidArgumentException("{$type} is not a valid argument. Use either \"discussion\" or \"comment\".");
		}

		return Validator::make(
			$params,
			[
				'id' => ['required', 'numeric', "exists:{$table},id"],
				'userID' => ['required', 'numeric', 'exists:users,id'],
				'action' => ['required', 'string', 'in:upvote,downvote,swap-to-upvote,swap-to-downvote,unvote']
			],
			[
				'id.required' => "{$type} ID is required",
				'id.numeric' => "Invalid ID format",
				'id.exists' => "{$type} entry does not exists",
				'userID.required' => "User ID is required",
				'userID.numeric' => "Invalid ID format",
				'userID.exists' => "User entry does not exists",
				'action.required' => "Action is required",
				'action.string' => "Invalid action format",
				'action.in' => "Invalid action. Must be one of the following: upvote, downvote, swap-to-upvote, swap-to-downvote, unvote"
			]
		);
	}

	/**
	 * Updates the account to require verification again. This will make the user unverified
	 * and unable to do anything unless the account is verified.
	 *
	 * This method will also send an email to the user to verify their account.
	 *
	 * For ease of use, this method will automatically get the authenticated user if no user
	 * is provided. Furthermore, this method will automatically generate a new token if the
	 * user does not have an existing token.
	 *
	 * In addition to that, the email arguments will be merged with the additional arguments
	 * to allow for more customization. The default arguments are:
	 * - subject: The subject of the email.
	 * - req: The request data.
	 * - email: The email of the user.
	 * - recipients: The recipients of the email.
	 * - code: The verification code.
	 *
	 * ***These arguments cannot be overridden.***
	 *
	 * @param EmailVerificationType|string $type The type of account to re-verify. Allowed values are provided by the `EmailVerificationType` enum.
	 * @param Illuminate/Validation/Validator $validator The validator instance.
	 * @param User $user The user to re-verify. Defaults to the authenticated user. (Optional but recommended)
	 * @param array $args Additional arguments to pass to the email view. (Optional)
	 *
	 * @throws Exception
	 */
	protected function reVerifyAccount(EmailVerificationType|string $type, \Illuminate\Validation\Validator $validator, User $user = null, array $args = []) {
		if ($user == null) {
			if (auth()->check())
				$user = auth()->user();
			else
				throw new Exception('No user provided and no authenticated user found.');
		}

		if ($type instanceof EmailVerificationType) {
			$enumType = $type;
			$subject = $type->getEmailSubject();
			$type = $type->getEmailView();
		}
		else {
			$enumType = EmailVerificationType::tryFromValue($type);
			$subject = $enumType?->getEmailSubject()
				?? "Account Re-Verification";
		}

		$cleanData = (object) $validator->validated();
		if (!property_exists($cleanData, 'email') || $cleanData->email == null)
			$cleanData->email = $user->email;

		$user->is_verified = 0;
		$user->save();
		if ($user->accountVerification()->count() <= 0) {
			$user->accountVerification()->create([
				'token' => substr(bin2hex(random_bytes(32)), 0, 16),
				'expires_at' => now()->addDay()
			]);
		}
		else {
			$user->accountVerification->generateToken();
		}

		// MAILER
		$reqArgs = $validator->validated();
		// dd($args);
		$args = array_merge($args, [
			'subject' => $subject,
			'req' => $reqArgs,
			'email' => $cleanData->email,
			'recipients' => [$cleanData->email],
			'code' => $user->accountVerification->token
		]);

		AccountNotification::dispatchAfterResponse(
			user: $user,
			type: $type,
			args: $args,
			callOnDestruct: true
		)->onQueue($type);
	}
}
