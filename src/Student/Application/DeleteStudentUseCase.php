<?php

declare(strict_types=1);

namespace Src\Student\Application;

use Src\Student\Domain\Contracts\StudentRepository;

final class DeleteStudentUseCase
{

    public function __construct(private StudentRepository $StudentRepository)
    {
    }

    public function execute( string|int $key ): void
    {

        $this->StudentRepository->delete($key);

    }
}
