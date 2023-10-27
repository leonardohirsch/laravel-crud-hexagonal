<?php

declare(strict_types=1);

namespace Src\Course\Domain\ValueObjects;

final class Name
{

    public function __construct(private string $name)
    {
        $this->name = trim($name);
    }

    public function value(): string
    {
        return $this->name;
    }

}
