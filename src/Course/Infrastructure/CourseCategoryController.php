<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\CourseCategoryRequest;

use Src\Course\Application\AttachCategoryUseCase;
use Src\Course\Application\DetachCategoryUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;
use Src\Course\Infrastructure\Helpers\PolymorphicValidationTrait;

use Src\Category\Infrastructure\Repositories\EloquentCategoryRepository;

final class CourseCategoryController
{
    use PolymorphicValidationTrait;

    private const BASE_MODEL = 'Course';
    private const ATTACH_TYPE = 'categories';
    private const ATTACH_MODEL = 'Category';

    public function __construct(
        private EloquentCourseRepository $courseRepository,
        private EloquentCategoryRepository $attachedRepository
    )
    { }

    public function attach(CourseCategoryRequest $request, string|int $courseId)
    {

        $attach_ids = $this->parseAttachedIds( $request->input(self::ATTACH_TYPE) );

        try {

            $this->validate($courseId, $attach_ids);

            $attachUseCase = new AttachCategoryUseCase($this->courseRepository);
            $attachUseCase-> execute ( $courseId, $attach_ids );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }

    public function detach(CourseCategoryRequest $request, string|int $courseId)
    {

        $attach_ids = $this->parseAttachedIds( $request->input(self::ATTACH_TYPE) );

        try {

            $this->validate($courseId, $attach_ids);

            $detachUseCase = new DetachCategoryUseCase($this->courseRepository);
            $detachUseCase-> execute ( $courseId, $attach_ids );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
