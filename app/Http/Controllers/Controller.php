<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\UploadedFile;

use Intervention\Image\Image as IImage;

use Image;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

	const ADMIN_QUERY_PARAMS = ["search", "sort", "direction", "page"];
	const ADMIN_EXCEPT = ["_token", "search", "sort", "direction", "page"];

	/**
	 * Format the errors from the validator into a format that allows
	 * XHR requests to easily parse the errors.
	 *
	 * @param Validator $validator
	 * @return array
	 */
	protected function formatErrors(Validator $validator): array
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

	protected function convertToWEBP(string $filename, UploadedFile $image, string $saveToPath, $quality = 75): IImage
	{
		$path = public_path("{$saveToPath}/{$filename}");

		$image = Image::make($image);
		$image->encode('webp', $quality)
			->save($path);

		return $image;
	}
}
