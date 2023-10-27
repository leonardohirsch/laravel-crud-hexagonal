<?php

declare(strict_types=1);

namespace Src\Document\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Src\Document\Application\DeleteDocumentUseCase;
use Src\Document\Application\GetDocumentByUseCase;
use Src\Document\Infrastructure\Repositories\EloquentDocumentRepository;

final class DeleteDocumentController
{

    public function __construct(private EloquentDocumentRepository $repository)
    { }

    private function removeDocumentFile( string $filePath ): void
    {
        if ( Storage::exists( $filePath ) ) {

            Storage::delete( $filePath );

        }
    }

    public function __invoke(Request $request, string $key)
    {
        try {

            $getDocument = new GetDocumentByUseCase( $this->repository );

            $document = $getDocument->execute( $key );

            if ( is_null( $document ) ) {

                throw new \Exception('Record does not exist');

            }

            $documentData = $document->getPublicEntityData();

            $documentPath = $documentData['path'];

            $deleteDocumentUseCase = new DeleteDocumentUseCase($this->repository);
            $deleteDocumentUseCase->execute( $key );

            $this->removeDocumentFile( $documentPath );

            return response()->json(200);

        } catch (\Exception $e){

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {

            return response()->json([ 'message'=> $e->getMessage() ], 500);

        }

    }
}
