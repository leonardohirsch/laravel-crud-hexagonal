<?php

declare(strict_types=1);

namespace Src\Course\Application;

use Src\Course\Domain\Contracts\CourseRepository;

final class AttachDocumentUseCase
{
    private const ATTACHABLE_TYPE = 'documents';

    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function execute(int|string $courseId, array $attachable_ids): void
    {

        $this->courseRepository->attachCourseable(
            $courseId,
            self::ATTACHABLE_TYPE,
            $attachable_ids
        );

    }
}
