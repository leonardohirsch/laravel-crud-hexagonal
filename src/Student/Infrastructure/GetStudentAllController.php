<?php

declare(strict_types=1);

namespace Src\Student\Infrastructure;

use Illuminate\Http\Request;

use Src\Student\Application\GetStudentAllUseCase;
use Src\Student\Infrastructure\Repositories\EloquentStudentRepository;

final class GetStudentAllController
{

    public function __construct(private EloquentStudentRepository $repository)
    { }

    public function __invoke(Request $request)
    {

        $offset = $request->input('offset', GetStudentAllUseCase::DEFAULT_OFFSET);
        $limit = $request->input('limit', GetStudentAllUseCase::DEFAULT_LIMIT);

        if ( !is_numeric($offset) ) {
            $offset = GetStudentAllUseCase::DEFAULT_OFFSET;
        }

        if ( !is_numeric($limit) ) {
            $limit = GetStudentAllUseCase::DEFAULT_LIMIT;
        }

        $getStudentAllUseCase = new GetStudentAllUseCase($this->repository);
        $data = $getStudentAllUseCase -> execute ( intval($offset), intval($limit));

        return response()->json([ 'data' => $data ], 200);

    }
}
