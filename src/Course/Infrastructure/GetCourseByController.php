<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure;

use Illuminate\Http\Request;

use Src\Course\Application\GetCourseByUseCase;
use Src\Course\Infrastructure\Repositories\EloquentCourseRepository;

final class GetCourseByController
{

    public function __construct(private EloquentCourseRepository $repository)
    { }

    public function __invoke(Request $request, string $key)
    {

        $getCourseByUseCase = new GetCourseByUseCase($this->repository);
        $data = $getCourseByUseCase -> execute ( $key );

        if ( is_object($data) ) $data = $data->getPublicEntityData();

        return response()->json([ 'data' => $data ], 200);

    }
}
