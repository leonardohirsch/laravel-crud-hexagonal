<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;

use Src\Course\Application\DeleteCourseUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;

final class DeleteCourseController
{

    public function __construct(private EloquentCourseRepository $repository)
    { }

    public function __invoke(Request $request, string $key)
    {
        try {

            $deleteCourseUseCase = new DeleteCourseUseCase($this->repository);
            $deleteCourseUseCase->execute( $key );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
