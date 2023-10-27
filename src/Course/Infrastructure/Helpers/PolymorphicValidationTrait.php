<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure\Helpers;

use Src\Course\Application\GetCourseByUseCase;

trait  PolymorphicValidationTrait {

    private function parseAttachedIds( string $attach_ids): array
    {
        $attach_ids = preg_replace('/\s+,\s+/', ',', $attach_ids);
        $attach_ids = preg_replace('/,$/', '', $attach_ids);
        return explode(",", $attach_ids);
    }

    private function validate(string|int $model_id, array $attach_ids): void
    {
        $course = new GetCourseByUseCase( $this->courseRepository );

            if ( is_null( $course->execute( $model_id ) ) ) {

                throw new \Exception(self::BASE_MODEL. ' ' .$model_id. ' does not exist');

            }

            foreach ($attach_ids as $attach_id) {

                $model = $this->attachedRepository->find($attach_id);

                if ( is_null($model) ) {

                    throw new \Exception(self::ATTACH_MODEL. ' ' .$attach_id. ' does not exist');

                }

                $model = null;
            }

    }
}
