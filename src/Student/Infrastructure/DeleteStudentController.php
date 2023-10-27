<?php

declare(strict_types=1);

namespace Src\Student\Infrastructure;

use Illuminate\Http\Request;

use Src\Student\Application\DeleteStudentUseCase;
use Src\Student\Infrastructure\Repositories\EloquentStudentRepository;

final class DeleteStudentController
{

    public function __construct(private EloquentStudentRepository $repository)
    { }

    public function __invoke(Request $request, string $key)
    {
        try {

            $deleteStudentUseCase = new DeleteStudentUseCase($this->repository);
            $deleteStudentUseCase->execute( $key );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
