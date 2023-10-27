<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;

use Src\Category\Application\CreateCategoryUseCase;
use Src\Category\Application\GetCategoryByUseCase;
use Src\Category\Infrastructure\Repositories\EloquentCategoryRepository;

final class CreateCategoryController
{

    public function __construct(private EloquentCategoryRepository $repository)
    { }

    public function __invoke(StoreCategoryRequest $request)
    {

        $CategoryName = $request->input('name');

        try {


            $createCategoryUseCase = new CreateCategoryUseCase($this->repository);
            $createCategoryUseCase-> execute ( $CategoryName );

            $getNewCategory = new GetCategoryByUseCase($this->repository);
            $newCategory = $getNewCategory -> execute ( $CategoryName );
            $newCategoryData = $newCategory->getPublicEntityData();

            return response()->json([ 'data' => $newCategoryData ], 200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
