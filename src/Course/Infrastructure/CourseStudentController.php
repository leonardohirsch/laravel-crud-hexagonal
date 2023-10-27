<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\CourseStudentRequest;

use Src\Course\Application\AttachStudentUseCase;
use Src\Course\Application\DetachStudentUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;
use Src\Course\Infrastructure\Helpers\PolymorphicValidationTrait;

use Src\Student\Infrastructure\Repositories\EloquentStudentRepository;


final class CourseStudentController
{

    use PolymorphicValidationTrait;

    private const BASE_MODEL = 'Course';
    private const ATTACH_TYPE = 'students';
    private const ATTACH_MODEL = 'Student';

    public function __construct(
        private EloquentCourseRepository $courseRepository,
        private EloquentStudentRepository $attachedRepository
    )
    { }

    public function attach(CourseStudentRequest $request, string|int $courseId)
    {

        $attach_ids = $this->parseAttachedIds( $request->input(self::ATTACH_TYPE) );

        try {

            $this->validate($courseId, $attach_ids);

            $attachUseCase = new AttachStudentUseCase($this->courseRepository);
            $attachUseCase-> execute ( $courseId, $attach_ids );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }

    public function detach(CourseStudentRequest $request, string|int $courseId)
    {

        $attach_ids = $this->parseAttachedIds( $request->input(self::ATTACH_TYPE) );

        try {

            $this->validate($courseId, $attach_ids);

            $detachUseCase = new DetachStudentUseCase($this->courseRepository);
            $detachUseCase-> execute ( $courseId, $attach_ids );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
