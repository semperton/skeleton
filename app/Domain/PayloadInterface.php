<?php

declare(strict_types=1);

namespace App\Domain;

interface PayloadInterface
{
	const string STATUS_AUTHENTICATED = 'AUTHENTICATED';
	const string STATUS_NOT_AUTHENTICATED = 'NOT_AUTHENTICATED';

	const string STATUS_AUTHORIZED = 'AUTHORIZED';
	const string STATUS_NOT_AUTHORIZED = 'NOT_AUTHORIZED';

	const string STATUS_ACCEPTED = 'ACCEPTED';
	const string STATUS_NOT_ACCEPTED = 'NOT_ACCEPTED';

	const string STATUS_CREATED = 'CREATED';
	const string STATUS_NOT_CREATED = 'NOT_CREATED';

	const string STATUS_DELETED = 'DELETED';
	const string STATUS_NOT_DELETED = 'NOT_DELETED';

	const string STATUS_FOUND = 'FOUND';
	const string STATUS_NOT_FOUND = 'NOT_FOUND';

	const string STATUS_UPDATED = 'UPDATED';
	const string STATUS_NOT_UPDATED = 'NOT_UPDATED';

	const string STATUS_SUCCESS = 'SUCCESS';
	const string STATUS_ERROR = 'ERROR';

	const string STATUS_VALID = 'VALID';
	const string STATUS_NOT_VALID = 'NOT_VALID';

	const string STATUS_CONFLICT = 'CONFLICT';

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
