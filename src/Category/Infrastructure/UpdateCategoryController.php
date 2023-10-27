<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateCategoryRequest;

use Src\Category\Application\UpdateCategoryUseCase;
use Src\Category\Infrastructure\Repositories\EloquentCategoryRepository;

final class UpdateCategoryController
{

    public function __construct(private EloquentCategoryRepository $repository)
    { }

    public function __invoke(UpdateCategoryRequest $request, string $key)
    {
        try {

            $updateCategoryUseCase = new UpdateCategoryUseCase($this->repository);
            $updateCategoryUseCase->execute( $key, $request->all()  );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
