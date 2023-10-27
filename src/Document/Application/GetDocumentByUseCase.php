<?php

declare(strict_types=1);

namespace Src\Document\Application;

use Src\Document\Domain\DocumentEntity;
use Src\Document\Domain\Contracts\DocumentRepository;

final class GetDocumentByUseCase
{

    public function __construct(private DocumentRepository $DocumentRepository)
    {
    }

    public function execute( int|string $key ): ?DocumentEntity
    {
        return $this->DocumentRepository->find($key);

    }
}
