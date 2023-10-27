<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure;

use Illuminate\Http\Request;

use Src\Category\Application\GetCategoryAllUseCase;
use Src\Category\Infrastructure\Repositories\EloquentCategoryRepository;

final class GetCategoryAllController
{

    public function __construct(private EloquentCategoryRepository $repository)
    { }

    public function __invoke(Request $request)
    {

        $offset = $request->input('offset', GetCategoryAllUseCase::DEFAULT_OFFSET);
        $limit = $request->input('limit', GetCategoryAllUseCase::DEFAULT_LIMIT);

        if ( !is_numeric($offset) ) {
            $offset = GetCategoryAllUseCase::DEFAULT_OFFSET;
        }

        if ( !is_numeric($limit) ) {
            $limit = GetCategoryAllUseCase::DEFAULT_LIMIT;
        }

        $getCategoryAllUseCase = new GetCategoryAllUseCase($this->repository);
        $data = $getCategoryAllUseCase -> execute ( intval($offset), intval($limit));

        return response()->json([ 'data' => $data ], 200);

    }
}
