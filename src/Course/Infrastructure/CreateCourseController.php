<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Support\Str;

use Src\Course\Application\CreateCourseUseCase;
use Src\Course\Application\GetCourseByUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;

final class CreateCourseController
{

    public function __construct(private EloquentCourseRepository $repository)
    { }

    public function __invoke(StoreCourseRequest $request)
    {

        $courseName = $request->input('name');
        $courseDescription = $request->input('description');
        $courseSlug = Str::slug(strtolower($request->input('name')));

        try {

            $courseExists = new GetCourseByUseCase( $this->repository );

            if ( $courseExists->execute( $courseSlug ) ) {

                throw new \Exception('Slug already exists');

            }

            $createCourseUseCase = new CreateCourseUseCase($this->repository);
            $createCourseUseCase-> execute (
                $courseName,
                $courseDescription,
                $courseSlug
            );

            $getNewCourse = new GetCourseByUseCase($this->repository);
            $newCourse = $getNewCourse -> execute ( $courseSlug );
            $newCourseData = $newCourse->getPublicEntityData();

            return response()->json([ 'data' => $newCourseData ], 200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
