<?php

declare(strict_types=1);

namespace Src\Course\Application;

use Src\Course\Domain\Contracts\CourseRepository;

final class DeleteCourseUseCase
{

    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function execute( string|int $key ): void
    {

        $this->courseRepository->delete($key);

    }
}
