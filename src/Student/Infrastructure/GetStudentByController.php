<?php

declare(strict_types=1);

namespace Src\Student\Infrastructure;

use Illuminate\Http\Request;

use Src\Student\Application\GetStudentByUseCase;
use Src\Student\Infrastructure\Repositories\EloquentStudentRepository;

final class GetStudentByController
{

    public function __construct(private EloquentStudentRepository $repository)
    { }

    public function __invoke(Request $request, string $key)
    {

        $getStudentByUseCase = new GetStudentByUseCase($this->repository);
        $data = $getStudentByUseCase -> execute ( $key );

        if ( is_object($data) ) $data = $data->getPublicEntityData();

        return response()->json([ 'data' => $data ], 200);

    }
}
