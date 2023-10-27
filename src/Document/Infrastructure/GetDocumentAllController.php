<?php

declare(strict_types=1);

namespace Src\Document\Infrastructure;

use Illuminate\Http\Request;

use Src\Document\Application\GetDocumentAllUseCase;
use Src\Document\Infrastructure\Repositories\EloquentDocumentRepository;

final class GetDocumentAllController
{

    public function __construct(private EloquentDocumentRepository $repository)
    { }

    public function __invoke(Request $request)
    {

        $offset = $request->input('offset', GetDocumentAllUseCase::DEFAULT_OFFSET);
        $limit = $request->input('limit', GetDocumentAllUseCase::DEFAULT_LIMIT);

        if ( !is_numeric($offset) ) {
            $offset = GetDocumentAllUseCase::DEFAULT_OFFSET;
        }

        if ( !is_numeric($limit) ) {
            $limit = GetDocumentAllUseCase::DEFAULT_LIMIT;
        }

        $getDocumentAllUseCase = new GetDocumentAllUseCase($this->repository);
        $data = $getDocumentAllUseCase -> execute ( intval($offset), intval($limit));

        return response()->json([ 'data' => $data ], 200);

    }
}
