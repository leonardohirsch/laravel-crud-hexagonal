<?php

declare(strict_types=1);

namespace Src\Document\Application;

use Src\Document\Domain\DocumentEntity;
use Src\Document\Domain\ValueObjects\Name;
use Src\Document\Domain\ValueObjects\Path;
use Src\Document\Domain\Contracts\DocumentRepository;

final class CreateDocumentUseCase
{

    public function __construct(private DocumentRepository $DocumentRepository)
    {
    }

    public function execute(string $name, string $path): void
    {

        $Document = new DocumentEntity(
            name: new Name($name),
            path: new Path($path),
        );

        $this->DocumentRepository->create($Document);

    }
}
