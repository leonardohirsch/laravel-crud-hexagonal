<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;

use Src\Course\Application\GetCourseAllUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;

final class GetCourseAllController
{

    public function __construct(private EloquentCourseRepository $repository)
    { }

    public function __invoke(Request $request)
    {

        $offset = $request->input('offset', GetCourseAllUseCase::DEFAULT_OFFSET);
        $limit = $request->input('limit', GetCourseAllUseCase::DEFAULT_LIMIT);

        if ( !is_numeric($offset) ) {
            $offset = GetCourseAllUseCase::DEFAULT_OFFSET;
        }

        if ( !is_numeric($limit) ) {
            $limit = GetCourseAllUseCase::DEFAULT_LIMIT;
        }

        $getCourseAllUseCase = new GetCourseAllUseCase($this->repository);
        $data = $getCourseAllUseCase -> execute ( intval($offset), intval($limit));

        return response()->json([ 'data' => $data ], 200);

    }
}
