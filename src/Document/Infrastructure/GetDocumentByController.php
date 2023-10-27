<?php

declare(strict_types=1);

namespace Src\Document\Infrastructure;

use Illuminate\Http\Request;

use Src\Document\Application\GetDocumentByUseCase;
use Src\Document\Infrastructure\Repositories\EloquentDocumentRepository;

final class GetDocumentByController
{

    public function __construct(private EloquentDocumentRepository $repository)
    { }

    public function __invoke(Request $request, string $key)
    {

        $getDocumentByUseCase = new GetDocumentByUseCase($this->repository);
        $data = $getDocumentByUseCase -> execute ( $key );

        if ( is_object($data) ) $data = $data->getPublicEntityData();

        return response()->json([ 'data' => $data ], 200);

    }
}
