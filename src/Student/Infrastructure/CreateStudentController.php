<?php

declare(strict_types=1);

namespace Src\Student\Infrastructure;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;

use Src\Student\Application\CreateStudentUseCase;
use Src\Student\Application\GetStudentByUseCase;
use Src\Student\Infrastructure\Repositories\EloquentStudentRepository;

final class CreateStudentController
{

    public function __construct(private EloquentStudentRepository $repository)
    { }

    public function __invoke(StoreStudentRequest $request)
    {

        $StudentName = $request->input('name');
        $StudentEmail = $request->input('email');

        try {


            $createStudentUseCase = new CreateStudentUseCase($this->repository);
            $createStudentUseCase-> execute (
                $StudentName,
                $StudentEmail
            );

            $getNewStudent = new GetStudentByUseCase($this->repository);
            $newStudent = $getNewStudent -> execute ( $StudentEmail );
            $newStudentData = $newStudent->getPublicEntityData();

            return response()->json([ 'data' => $newStudentData ], 200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {
            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
