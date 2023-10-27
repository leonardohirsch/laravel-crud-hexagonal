<?php

declare(strict_types=1);

namespace Src\Document\Domain\Contracts;

use Src\Document\Domain\DocumentEntity;

interface DocumentRepository
{

    public function create ( DocumentEntity $data ): void;

    public function find ( string|int $key ): ?DocumentEntity;

    public function all (int $offset, ?int $limit ): array;

    public function update ( string|int $key, array $data ): void;

    public function delete( string|int $key ): void;
}
