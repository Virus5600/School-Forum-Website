<?php

namespace App\Enums;

use App\Traits\BaseEnumTraits;

use Exception;

enum ReportStatus: string {
	use BaseEnumTraits;

	case PENDING_REVIEW = "pending review";
	case UNDER_REVIEW = "under review";
	case REVIEWED = "reviewed";

	/**
	 * Get the associated color of the status. The color that will be returned
	 * is a value that will have to be used inside a style attribute. An option
	 * to return the color as a class is also available but requires Bootstrap 5.
	 *
	 * @param bool $isBootstrap5 Whether to use Bootstrap 5 CSS variables.
	 * @param bool $asClass Whether to return the color as a class.
	 *
	 * @return string The color of the status.
	 *
	 * @throws Exception If `$asClass` is true but Bootstrap 5 is not used or `false`.
	 */
	public function getColors(bool $isBootstrap5 = false, bool $asClass = false): string
	{
		$colors = [
			self::PENDING_REVIEW->value => "#6c757d",
			self::UNDER_REVIEW->value => "#ffc107",
			self::REVIEWED->value => "#198754",
		];

		if ($isBootstrap5) {
			if ($asClass) {
				$colors = [
					self::PENDING_REVIEW->value => "secondary",
					self::UNDER_REVIEW->value => "warning",
					self::REVIEWED->value => "success",
				];
			}
			else {
				$colors = [
					self::PENDING_REVIEW->value => "var(--bs-secondary)",
					self::UNDER_REVIEW->value => "var(--bs-warning)",
					self::REVIEWED->value => "var(--bs-success)",
				];
			}
		}

		if (!$isBootstrap5 && $asClass)
			throw new Exception("Bootstrap 5 is required to use asClass parameter.");

		return $colors[$this->value];
	}
}
