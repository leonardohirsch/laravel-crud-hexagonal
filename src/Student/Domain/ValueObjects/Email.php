<?php

declare(strict_types=1);

namespace Src\Student\Domain\ValueObjects;

final class Email
{

    public function __construct(private string $email)
    {
        $this->email = strtolower ( trim( $email ) );
    }

    public function value(): string
    {
        return $this->email;
    }

}
