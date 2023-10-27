<?php

declare(strict_types=1);

namespace Src\Category\Application;

use Src\Category\Domain\CategoryEntity;
use Src\Category\Domain\Contracts\CategoryRepository;

final class GetCategoryByUseCase
{

    public function __construct(private CategoryRepository $CategoryRepository)
    {
    }

    public function execute( int|string $key ): ?CategoryEntity
    {

        return $this->CategoryRepository->find($key);

    }
}
