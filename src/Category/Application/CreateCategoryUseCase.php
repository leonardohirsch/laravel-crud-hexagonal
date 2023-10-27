<?php

declare(strict_types=1);

namespace Src\Category\Application;

use Src\Category\Domain\CategoryEntity;
use Src\Category\Domain\ValueObjects\Name;
use Src\Category\Domain\Contracts\CategoryRepository;

final class CreateCategoryUseCase
{

    public function __construct(private CategoryRepository $CategoryRepository)
    {
    }

    public function execute(string $name): void
    {

        $Category = new CategoryEntity(
            name: new Name($name),
        );

        $this->CategoryRepository->create($Category);

    }
}
