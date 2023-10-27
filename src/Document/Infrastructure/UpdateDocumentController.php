<?php

declare(strict_types=1);

namespace Src\Document\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateDocumentRequest;

use Src\Document\Application\GetDocumentByUseCase;
use Src\Document\Application\UpdateDocumentUseCase;
use Src\Document\Infrastructure\Repositories\EloquentDocumentRepository;

final class UpdateDocumentController
{
    private const UPLOAD_PATH = 'docs';
    private const UPLOAD_DISC = 'local';
    private string $documentPath;

    public function __construct(private EloquentDocumentRepository $repository)
    { }

    private function removeDocumentFile( string $filePath ): void
    {
        if ( Storage::exists( $filePath ) ) {

            Storage::delete( $filePath );

        }
    }

    public function __invoke(UpdateDocumentRequest $request, string $key)
    {

        try {

            $requestInputs = $request->all();

            if ( $request->hasFile('file') ) {

                $DocumentFile = $request->file('file');

                $fileName = Str::random(40);

                $extension = $DocumentFile->getClientOriginalExtension();

                $fileName = $fileName . '.' . $extension;

                $this->documentPath = $DocumentFile->storeAs(self::UPLOAD_PATH, $fileName, self::UPLOAD_DISC);

                $requestInputs['path'] = $this->documentPath;

                unset($requestInputs['file']);

                $getDocument = new GetDocumentByUseCase( $this->repository );

                $document = $getDocument->execute( $key );

                if ( is_null( $document ) ) {

                    throw new \Exception('Record does not exist');

                }

                $originalDocData = $document->getPublicEntityData();

                $oldDocFilePath = $originalDocData['path'];

                $this->removeDocumentFile( $oldDocFilePath );

            }

            $updateDocumentUseCase = new UpdateDocumentUseCase($this->repository);
            $updateDocumentUseCase->execute( $key, $requestInputs );

            return response()->json(200);

        } catch (\Exception $e){

            $this->removeDocumentFile( $this->documentPath );

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {

            $this->removeDocumentFile( $this->documentPath );

            return response()->json([ 'message'=> $e->getMessage() ], 500);

        }

    }
}
