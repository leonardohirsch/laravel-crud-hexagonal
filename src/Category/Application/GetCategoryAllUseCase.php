<?php

declare(strict_types=1);

namespace Src\Category\Application;

use Src\Category\Domain\Contracts\CategoryRepository;

final class GetCategoryAllUseCase
{
    public const DEFAULT_OFFSET = 0;
    public const DEFAULT_LIMIT = 5;
    private const MAX_LIMIT = 5;

    public function __construct(private CategoryRepository $CategoryRepository)
    {
    }

    public function execute(
        int $offset = self::DEFAULT_OFFSET,
        ?int $limit = self::DEFAULT_LIMIT
    ): array
    {

        if ( !is_numeric($offset) ) {
            $offset = self::DEFAULT_OFFSET;
        }

        if ( !is_numeric($limit) ) {
            $limit = self::DEFAULT_LIMIT;
        }

        if ( $limit > self::MAX_LIMIT ) {
            $limit = self::DEFAULT_LIMIT;
        }

        return $this->CategoryRepository->all( $offset, $limit );

    }
}
