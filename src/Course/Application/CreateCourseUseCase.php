<?php

declare(strict_types=1);

namespace Src\Course\Application;

use Src\Course\Domain\CourseEntity;
use Src\Course\Domain\ValueObjects\Name;
use Src\Course\Domain\ValueObjects\Description;
use Src\Course\Domain\ValueObjects\Slug;
use Src\Course\Domain\Contracts\CourseRepository;

final class CreateCourseUseCase
{

    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function execute(string $name, string $description, string $slug): void
    {

        $course = new CourseEntity(
            name: new Name($name),
            slug: new Slug($slug),
            description: new Description($description),
        );

        $this->courseRepository->create($course);

    }
}
