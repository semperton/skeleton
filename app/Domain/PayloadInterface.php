<?php

declare(strict_types=1);

namespace App\Domain;

interface PayloadInterface
{
	const STATUS_AUTHENTICATED = 'AUTHENTICATED';
	const STATUS_NOT_AUTHENTICATED = 'NOT_AUTHENTICATED';

	const STATUS_AUTHORIZED = 'AUTHORIZED';
	const STATUS_NOT_AUTHORIZED = 'NOT_AUTHORIZED';

	const STATUS_ACCEPTED = 'ACCEPTED';
	const STATUS_NOT_ACCEPTED = 'NOT_ACCEPTED';

	const STATUS_CREATED = 'CREATED';
	const STATUS_NOT_CREATED = 'NOT_CREATED';

	const STATUS_DELETED = 'DELETED';
	const STATUS_NOT_DELETED = 'NOT_DELETED';

	const STATUS_FOUND = 'FOUND';
	const STATUS_NOT_FOUND = 'NOT_FOUND';

	const STATUS_UPDATED = 'UPDATED';
	const STATUS_NOT_UPDATED = 'NOT_UPDATED';

	const STATUS_SUCCESS = 'SUCCESS';
	const STATUS_ERROR = 'ERROR';

	const STATUS_VALID = 'VALID';
	const STATUS_NOT_VALID = 'NOT_VALID';

	const STATUS_CONFLICT = 'CONFLICT';

	public function withStatus(string $status): PayloadInterface;
	public function getStatus(): string;
	public function withInput(mixed $input): PayloadInterface;
	public function getInput(): mixed;
	public function withOutput(mixed $output): PayloadInterface;
	public function getOutput(): mixed;
	/**
	 * @param string[] $messages
	 */
	public function withMessages(array $messages): PayloadInterface;
	/**
	 * @return string[]
	 */
	public function getMessages(): array;
}
