<?php

declare(strict_types=1);

namespace Src\Course\Domain\ValueObjects;

final class Slug
{

    public function __construct(private string $slug)
    {
        $this->slug = strtolower(trim($slug));
    }

    public function value(): string
    {
        return $this->slug;
    }

}
