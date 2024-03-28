<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\UserType;

use Hash;
use InvalidArgumentException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$gender = rand(0, 1) ? "male" : "female";

        return [
			'username' => fake()->userName(),
            'first_name' => fake()->firstName($gender),
			'middle_name' => fake()->optional()->firstName($gender),
			'last_name' => fake()->lastName($gender),
			'suffix' => fake()->optional()->suffix(),
            'email' => fake()->unique()->safeEmail(),
			'gender' => $gender,
			'avatar' => "default-{$gender}.png",
			'user_type_id' => rand(3, 4),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
        ];
    }

	/**
	 * Provides a user with a specific username.
	 */
	public function username(string $username): static
	{
		return $this->state(fn (array $attributes) => [
			'username' => $username,
		]);
	}

	/**
	 * Provides a user with a specific first name.
	 */
	public function firstName(string $firstName): static
	{
		return $this->state(fn (array $attributes) => [
			'first_name' => $firstName,
		]);
	}

	/**
	 * Provides a user with a specific middle name.
	 */
	public function middleName(string $middleName): static
	{
		return $this->state(fn (array $attributes) => [
			'middle_name' => $middleName,
		]);
	}

	/**
	 * Provides a user with a specific last name.
	 */
	public function lastName(string $lastName): static
	{
		return $this->state(fn (array $attributes) => [
			'last_name' => $lastName,
		]);
	}

	/**
	 * Provides a user with a specific suffix.
	 */
	public function suffix(string $suffix): static
	{
		return $this->state(fn (array $attributes) => [
			'suffix' => $suffix,
		]);
	}

	/**
	 * Provides a user with a specific email address.
	 */
	public function email(string $email): static
	{
		return $this->state(fn (array $attributes) => [
			'email' => $email,
		]);
	}

	/**
	 * Provides a user with a gender from the list of options.
	 * Available options:
	 * - male
	 * - female
	 * - others
	 */
	public function gender(string $gender): static
	{
		$ogGender = $gender;
		$gender = strtolower($ogGender);
		$availableGenders = [
			'male',
			'female',
			'others'
		];

		if (!in_array($gender, $availableGenders)) {
			throw new InvalidArgumentException("{$ogGender} is not a valid option.");
		}

		return $this->state(fn (array $attributes) => [
			'gender' => $gender,
		]);
	}

	/**
	 * Provides a user with a specific user type.
	 */
	public function userType(int $userType): static
	{
		if ($userType < 1 || $userType > UserType::count()) {
			throw new InvalidArgumentException("{$userType} is not a valid user type.");
		}

		return $this->state(fn (array $attributes) => [
			'user_type_id' => $userType,
		]);
	}

	/**
	 * Provides a user with a specific password credential.
	 *
	 * @param string $password The password to be used.
	 * @param bool $isHashed Indicates if the password is already hashed. Defaults to `false`.
	 */
	public function password(string $password, bool $isHashed = false): static
	{
		if (!$isHashed)
			$password = Hash::make($password);

		return $this->state(fn (array $attributes) => [
			'password' => $password,
		]);
	}

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
