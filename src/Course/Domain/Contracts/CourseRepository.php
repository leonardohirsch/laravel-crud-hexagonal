<?php

declare(strict_types=1);

namespace Src\Course\Domain\Contracts;

use Src\Course\Domain\CourseEntity;

interface CourseRepository
{

    public function create ( CourseEntity $data ): void;

    public function find ( string|int $key ): ?CourseEntity;

    public function all (int $offset, ?int $limit ): array;

    public function update ( string|int $key, array $data ): void;

    public function delete( string|int $key ): void;

    public function attachCourseable( string|int $id, string $courseable_type, array $courseable_ids ): void;

    public function detachCourseable( string|int $id, string $courseable_type, array $courseable_ids ): void;

}
