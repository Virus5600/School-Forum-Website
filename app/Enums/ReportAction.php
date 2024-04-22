<?php

namespace App\Enums;

use App\Traits\BaseEnumTraits;

use Exception;

enum ReportAction: string {
	use BaseEnumTraits;

	case AWAITING = "awaiting action";
	case IGNORE = "ignored";
	case WARN = "warned";
	case BAN = "banned";

	/**
	 * Get the associated color of the action. The color that will be returned
	 * is a value that will have to be used inside a style attribute. An option
	 * to return the color as a class is also available but requires Bootstrap 5.
	 *
	 * @param bool $isBootstrap5 Whether to use Bootstrap 5 CSS variables.
	 * @param bool $asClass Whether to return the color as a class.
	 *
	 * @return string The color of the action.
	 *
	 * @throws Exception If `$asClass` is true but Bootstrap 5 is not used or `false`.
	 */
	public function getColors(bool $isBootstrap5 = false, bool $asClass = false): string
	{
		$colors = [
			self::AWAITING->value => "#6c757d",
			self::IGNORE->value => "#0dcaf0",
			self::WARN->value => "#ffc107",
			self::BAN->value => "#dc3545",
		];

		if ($isBootstrap5) {
			if ($asClass) {
				$colors = [
					self::AWAITING->value => "secondary",
					self::IGNORE->value => "info",
					self::WARN->value => "warning",
					self::BAN->value => "danger",
				];
			}
			else {
				$colors = [
					self::AWAITING->value => "var(--bs-secondary)",
					self::IGNORE->value => "var(--bs-info)",
					self::WARN->value => "var(--bs-warning)",
					self::BAN->value => "var(--bs-danger)",
				];
			}
		}

		if (!$isBootstrap5 && $asClass)
			throw new Exception("Bootstrap 5 is required to use asClass parameter.");

		return $colors[$this->value];
	}
}
