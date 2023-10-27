<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Str;

use Src\Course\Application\UpdateCourseUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;

final class UpdateCourseController
{

    public function __construct(private EloquentCourseRepository $repository)
    { }

    public function __invoke(UpdateCourseRequest $request, string $key)
    {
        try {

            if ( $request->filled('name') ) {

                $slug = Str::slug( strtolower( trim($request->input('name')) ) );

                $request->merge(['slug' => $slug]);

            }

            $updateCourseUseCase = new UpdateCourseUseCase($this->repository);
            $updateCourseUseCase->execute( $key, $request->all()  );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
