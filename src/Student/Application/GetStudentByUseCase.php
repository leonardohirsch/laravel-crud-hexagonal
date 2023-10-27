<?php

declare(strict_types=1);

namespace Src\Student\Application;

use Src\Student\Domain\StudentEntity;
use Src\Student\Domain\Contracts\StudentRepository;

final class GetStudentByUseCase
{

    public function __construct(private StudentRepository $StudentRepository)
    {
    }

    public function execute( int|string $key ): ?StudentEntity
    {
        return $this->StudentRepository->find($key);

    }
}
