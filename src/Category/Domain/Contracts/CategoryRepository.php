<?php

declare(strict_types=1);

namespace Src\Category\Domain\Contracts;

use Src\Category\Domain\CategoryEntity;

interface CategoryRepository
{

    public function create ( CategoryEntity $data ): void;

    public function find ( string|int $key ): ?CategoryEntity;

    public function all (int $offset, ?int $limit ): array;

    public function update ( string|int $key, array $data ): void;

    public function delete( string|int $key ): void;
}
