<?php

namespace App\Enums;

use App\Traits\BaseEnumTraits;

enum EmailVerificationType: string {
	use BaseEnumTraits;

	case ACCOUNT_CREATION = "account_creation";
	case ACCOUNT_DEACTIVATION = "account_deactivation";
	case ACCOUNT_REACTIVATION = "account_reactivation";
	case EMAIL_UPDATE = "email_update";
	case PASSWORD_RESET = "password_reset";
	case PASSWORD_UPDATE = "password_update";

	/**
	 * Get the email subject for the type.
	 */
	function getEmailSubject(): string
	{
		return match ($this) {
			self::ACCOUNT_CREATION => "Account Verification",
			self::ACCOUNT_DEACTIVATION => "Your Account Has Been De-Activated",
			self::ACCOUNT_REACTIVATION => "Account Re-Activation",
			self::EMAIL_UPDATE => "Email Update Verification",
			self::PASSWORD_RESET => "Password Reset Verification",
			self::PASSWORD_UPDATE => "Password Update Verification",
		};
	}

	/**
	 * Get the email view for the type.
	 */
	function getEmailView(): string
	{
		return match ($this) {
			self::ACCOUNT_CREATION => "account_creation",
			self::ACCOUNT_DEACTIVATION => "account_deactivation",
			self::ACCOUNT_REACTIVATION => "verification",
			self::EMAIL_UPDATE => "email_update",
			self::PASSWORD_RESET => "change_password",
			self::PASSWORD_UPDATE => "password_update",
		};
	}

	/**
	 * Get the types that require a password.
	 *
	 * @return array
	 */
	static function getPasswordRequiredTypes(): array
	{
		return [
			self::ACCOUNT_CREATION,
			self::PASSWORD_RESET,
			self::PASSWORD_UPDATE,
		];
	}
}
