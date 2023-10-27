<?php

declare(strict_types=1);

namespace Src\Document\Domain\ValueObjects;

final class UpdatedAt
{

    public function __construct(private string $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function value(): string
    {
        return $this->updated_at;
    }

}
