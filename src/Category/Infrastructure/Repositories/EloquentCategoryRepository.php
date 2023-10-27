<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure\Repositories;

use App\Models\Category as EloquentCategoryModel;
use Src\Category\Domain\CategoryEntity;
use Src\Category\Domain\Contracts\CategoryRepository;
use Src\Category\Domain\ValueObjects\Name;

class EloquentCategoryRepository implements CategoryRepository
{

    public function __construct( private EloquentCategoryModel $model )
    { }

    private function findByCriteria( string|int $key ): ?EloquentCategoryModel
    {
        return ( is_numeric($key) ) ?
                $this->model::find($key) :
                $this->model::where('name', $key)->first();
    }

    public function create( CategoryEntity $Category ): void
    {
        $newCategory = $this->model;

        $data = [
            'name' => $Category->name()->value(),
        ];

        $newCategory->create( $data );
    }

    public function find( string|int $key ): ?CategoryEntity
    {
        $result = $this->findByCriteria($key);

        if ( is_null($result) ) {
            return null;
        }

        $Category = new CategoryEntity(
            name: new Name($result->name),
        );

        $Category->setId($result->id);
        $Category->setCreatedAt($result->created_at->__toString());
        $Category->setUpdatedAt($result->updated_at->__toString());

        return $Category;

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
        $Category = $this->findByCriteria($key);

        if ( is_null($Category) ) {
            throw new \Exception('Record does not exist');
        }

        if ( array_key_exists('name', $data) && trim( $data['name'] ) !== $Category->name )
        {
            $checkNewNameExists = $this->findByCriteria($data['name']);

            if ( !is_null( $checkNewNameExists ) ) {

                throw new \Exception('Another Category already exist with that name');

            }

        }

        $Category->update($data);

    }

    public function delete( string|int $key ): void
    {
        $Category = $this->findByCriteria($key);

        if ( is_null($Category) ) {
            throw new \Exception('Record does not exist');
        }

        $Category->delete();
    }
}
