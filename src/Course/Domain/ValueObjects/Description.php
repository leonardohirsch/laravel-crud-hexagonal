<?php

declare(strict_types=1);

namespace Src\Course\Domain\ValueObjects;

final class Description
{

    public function __construct(private null|string $description = null)
    {
        $this->description = is_string($description) ? trim( $description ) : null;
    }

    public function value(): ?string
    {
        return $this->description;
    }

}
