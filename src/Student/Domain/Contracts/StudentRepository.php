<?php

declare(strict_types=1);

namespace Src\Student\Domain\Contracts;

use Src\Student\Domain\StudentEntity;

interface StudentRepository
{

    public function create ( StudentEntity $data ): void;

    public function find ( string|int $key ): ?StudentEntity;

    public function all (int $offset, ?int $limit ): array;

    public function update ( string|int $key, array $data ): void;

    public function delete( string|int $key ): void;
}
