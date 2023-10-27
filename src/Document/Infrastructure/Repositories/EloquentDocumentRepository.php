<?php

declare(strict_types=1);

namespace Src\Document\Infrastructure\Repositories;

use App\Models\Document as EloquentDocumentModel;
use Src\Document\Domain\DocumentEntity;
use Src\Document\Domain\Contracts\DocumentRepository;
use Src\Document\Domain\ValueObjects\Name;
use Src\Document\Domain\ValueObjects\Path;

class EloquentDocumentRepository implements DocumentRepository
{

    public function __construct( private EloquentDocumentModel $model )
    { }

    private function findByCriteria( string|int $key ): ?EloquentDocumentModel
    {
        return ( is_numeric($key) ) ?
                $this->model::find($key) :
                $this->model::where('path', $key)->first();
    }

    public function create( DocumentEntity $Document ): void
    {
        $newDocument = $this->model;

        $data = [
            'name' => $Document->name()->value(),
            'path' => $Document->path()->value(),
        ];

        $newDocument->create( $data );
    }

    public function find( string|int $key ): ?DocumentEntity
    {
        $result = $this->findByCriteria($key);

        if ( is_null($result) ) {
            return null;
        }

        $Document = new DocumentEntity(
            name: new Name($result->name),
            path: new Path($result->path),
        );

        $Document->setId($result->id);
        $Document->setCreatedAt($result->created_at->__toString());
        $Document->setUpdatedAt($result->updated_at->__toString());

        return $Document;

    }

    public function all(int $offset, ?int $limit ): array
    {
        return $this->model::select("*")
                        ->offset($offset)
                        ->limit($limit)
                        ->get()->toArray();

    }

    public function update( string|int $key, array $data ): void
    {
        $Document = $this->findByCriteria($key);

        if ( is_null($Document) ) {
            throw new \Exception('Record does not exist');
        }

        if ( array_key_exists('path', $data) && trim( $data['path'] ) !== $Document->path )
        {
            $checkNewPathExists = $this->findByCriteria($data['path']);

            if ( !is_null( $checkNewPathExists ) ) {

                throw new \Exception('Another Document already exist with that path');

            }

        }

        $Document->update($data);

    }

    public function delete( string|int $key ): void
    {
        $Document = $this->findByCriteria($key);

        if ( is_null($Document) ) {
            throw new \Exception('Record does not exist');
        }

        $Document->delete();
    }
}
