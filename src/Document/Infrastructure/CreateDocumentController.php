<?php

declare(strict_types=1);

namespace Src\Document\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDocumentRequest;


use Src\Document\Application\CreateDocumentUseCase;
use Src\Document\Application\GetDocumentByUseCase;
use Src\Document\Infrastructure\Repositories\EloquentDocumentRepository;

final class CreateDocumentController
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

    public function __invoke(StoreDocumentRequest $request)
    {

        try {

            if ( !$request->hasFile('file') ) {

                throw new \Exception('Document must have a file');

            }

            $DocumentName = $request->input('name');

            $DocumentFile = $request->file('file');

            $fileName = Str::random(40);

            $extension = $DocumentFile->getClientOriginalExtension();

            $fileName = $fileName . '.' . $extension;

            $this->documentPath = $DocumentFile->storeAs(self::UPLOAD_PATH, $fileName, self::UPLOAD_DISC);

            $createDocumentUseCase = new CreateDocumentUseCase($this->repository);

            $createDocumentUseCase-> execute (
                $DocumentName,
                $this->documentPath
            );


            $getNewDocument = new GetDocumentByUseCase($this->repository);

            $newDocument = $getNewDocument -> execute ( $this->documentPath );

            $newDocumentData = $newDocument->getPublicEntityData();

            return response()->json([ 'data' => $newDocumentData ], 200);

        } catch (\Exception $e){

            $this->removeDocumentFile( $this->documentPath );

            return response()->json([ 'message'=> $e->getMessage() ], 400);

        } catch (\Error $e) {

            $this->removeDocumentFile( $this->documentPath );

            return response()->json([ 'message'=> $e->getMessage() ], 500);
        }

    }
}
