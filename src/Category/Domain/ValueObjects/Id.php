<?php

declare(strict_types=1);

namespace Src\Category\Domain\ValueObjects;

final class Id
{

    public function __construct(private string|int $id)
    {
        $this->id = $id;
    }

    public function value(): string | int
    {
        return $this->id;
    }

}
