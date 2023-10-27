<?php

declare(strict_types=1);

namespace Src\Document\Application;

use Src\Document\Domain\Contracts\DocumentRepository;

final class DeleteDocumentUseCase
{

    public function __construct(private DocumentRepository $DocumentRepository)
    {
    }

    public function execute( string|int $key ): void
    {

        $this->DocumentRepository->delete($key);

    }
}
