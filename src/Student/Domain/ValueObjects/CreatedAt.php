<?php

declare(strict_types=1);

namespace Src\Student\Domain\ValueObjects;

final class CreatedAt
{

    public function __construct(private string $created_at)
    {
        $this->created_at = $created_at;
    }

    public function value(): string
    {
        return $this->created_at;
    }

}
