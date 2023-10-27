<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure;

use Illuminate\Http\Request;

use Src\Category\Application\GetCategoryByUseCase;
use Src\Category\Infrastructure\Repositories\EloquentCategoryRepository;

final class GetCategoryByController
{

    public function __construct(private EloquentCategoryRepository $repository)
    { }

    public function __invoke(Request $request, string $key)
    {

        $getCategoryByUseCase = new GetCategoryByUseCase($this->repository);
        $data = $getCategoryByUseCase -> execute ( $key );

        if ( is_object($data) ) $data = $data->getPublicEntityData();

        return response()->json([ 'data' => $data ], 200);

    }
}
