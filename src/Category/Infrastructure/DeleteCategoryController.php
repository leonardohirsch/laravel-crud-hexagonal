<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure;

use Illuminate\Http\Request;

use Src\Category\Application\DeleteCategoryUseCase;
use Src\Category\Infrastructure\Repositories\EloquentCategoryRepository;

final class DeleteCategoryController
{

    public function __construct(private EloquentCategoryRepository $repository)
    { }

    public function __invoke(Request $request, string $key)
    {
        try {

            $deleteCategoryUseCase = new DeleteCategoryUseCase($this->repository);
            $deleteCategoryUseCase->execute( $key );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
