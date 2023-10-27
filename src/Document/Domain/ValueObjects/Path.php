<?php

declare(strict_types=1);

namespace Src\Document\Domain\ValueObjects;

final class Path
{

    public function __construct(private string $path)
    {
        $this->path = trim($path);
    }

    public function value(): string
    {
        return $this->path;
    }

}
