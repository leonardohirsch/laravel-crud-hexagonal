<?php

declare(strict_types=1);

namespace Src\Student\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateStudentRequest;

use Src\Student\Application\UpdateStudentUseCase;
use Src\Student\Infrastructure\Repositories\EloquentStudentRepository;

final class UpdateStudentController
{

    public function __construct(private EloquentStudentRepository $repository)
    { }

    public function __invoke(UpdateStudentRequest $request, string $key)
    {
        try {

            $updateStudentUseCase = new UpdateStudentUseCase($this->repository);
            $updateStudentUseCase->execute( $key, $request->all()  );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
