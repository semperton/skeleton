<?php

declare(strict_types=1);

namespace App\Domain;

final class Payload implements PayloadInterface
{
    protected string $status;

    protected mixed $input;

    protected mixed $output;

    /** @var string[] */
    protected array $messages = [];

    public function __construct(string $status, mixed $output)
    {
        $this->status = $status;
        $this->output = $output;
    }

    #[\Override]
    public function withStatus(string $status): PayloadInterface
    {
        $payload = clone $this;
        $payload->status = $status;
        return $payload;
    }

    #[\Override]
    public function getStatus(): string
    {
        return $this->status;
    }

    #[\Override]
    public function withInput(mixed $input): PayloadInterface
    {
        $payload = clone $this;
        $payload->input = $input;
        return $payload;
    }

    #[\Override]
    public function getInput(): mixed
    {
        return $this->input;
    }

    #[\Override]
    public function withOutput(mixed $output): PayloadInterface
    {
        $payload = clone $this;
        $payload->output = $output;
        return $payload;
    }

    #[\Override]
    public function getOutput(): mixed
    {
        return $this->output;
    }

    #[\Override]
    public function withMessages(array $messages): PayloadInterface
    {
        $payload = clone $this;
        $payload->messages = $messages;
        return $payload;
    }

    /**
     * @return string[]
     */
    #[\Override]
    public function getMessages(): array
    {
        return $this->messages;
    }
}
