<?php

declare(strict_types=1);

namespace Src\Category\Application;

use Src\Category\Domain\Contracts\CategoryRepository;

final class DeleteCategoryUseCase
{

    public function __construct(private CategoryRepository $CategoryRepository)
    {
    }

    public function execute( string|int $key ): void
    {

        $this->CategoryRepository->delete($key);

    }
}
