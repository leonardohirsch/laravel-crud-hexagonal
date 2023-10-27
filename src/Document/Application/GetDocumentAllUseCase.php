<?php

declare(strict_types=1);

namespace Src\Document\Application;

use Src\Document\Domain\Contracts\DocumentRepository;

final class GetDocumentAllUseCase
{
    public const DEFAULT_OFFSET = 0;
    public const DEFAULT_LIMIT = 5;
    private const MAX_LIMIT = 5;

    public function __construct(private DocumentRepository $DocumentRepository)
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

        return $this->DocumentRepository->all( $offset, $limit );

    }
}
