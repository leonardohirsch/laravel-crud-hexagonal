<?php

declare(strict_types=1);

namespace Src\Student\Application;

use Src\Student\Domain\StudentEntity;
use Src\Student\Domain\ValueObjects\Name;
use Src\Student\Domain\ValueObjects\Email;
use Src\Student\Domain\Contracts\StudentRepository;

final class CreateStudentUseCase
{

    public function __construct(private StudentRepository $StudentRepository)
    {
    }

    public function execute(string $name, string $email): void
    {

        $Student = new StudentEntity(
            name: new Name($name),
            email: new Email($email),
        );

        $this->StudentRepository->create($Student);

    }
}
