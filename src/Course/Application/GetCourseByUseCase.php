<?php

declare(strict_types=1);

namespace Src\Course\Application;

use Src\Course\Domain\CourseEntity;
use Src\Course\Domain\Contracts\CourseRepository;

final class GetCourseByUseCase
{

    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function execute( int|string $key ): ?CourseEntity
    {
        return $this->courseRepository->find($key);

    }
}
