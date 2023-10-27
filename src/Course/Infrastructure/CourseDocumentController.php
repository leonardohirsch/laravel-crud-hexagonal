<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\CourseDocumentRequest;

use Src\Course\Application\AttachDocumentUseCase;
use Src\Course\Application\DetachDocumentUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;
use Src\Course\Infrastructure\Helpers\PolymorphicValidationTrait;

use Src\Document\Infrastructure\Repositories\EloquentDocumentRepository;

final class CourseDocumentController
{
    use PolymorphicValidationTrait;

    private const BASE_MODEL = 'Course';
    private const ATTACH_TYPE = 'documents';
    private const ATTACH_MODEL = 'Document';

    public function __construct(
        private EloquentCourseRepository $courseRepository,
        private EloquentDocumentRepository $attachedRepository
    )
    { }

    public function attach(CourseDocumentRequest $request, string|int $courseId)
    {

        $attach_ids = $this->parseAttachedIds( $request->input(self::ATTACH_TYPE) );

        try {

            $this->validate($courseId, $attach_ids);

            $attachUseCase = new AttachDocumentUseCase($this->courseRepository);
            $attachUseCase-> execute ( $courseId, $attach_ids );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }

    public function detach(CourseDocumentRequest $request, string|int $courseId)
    {

        $attach_ids = $this->parseAttachedIds( $request->input(self::ATTACH_TYPE) );

        try {

            $this->validate($courseId, $attach_ids);

            $detachUseCase = new DetachDocumentUseCase($this->courseRepository);
            $detachUseCase-> execute ( $courseId, $attach_ids );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
