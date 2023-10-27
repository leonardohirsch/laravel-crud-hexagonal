<?php

declare(strict_types=1);

namespace Src\Category\Domain;
use Src\Category\Domain\ValueObjects\Id;
use Src\Category\Domain\ValueObjects\Name;
use Src\Category\Domain\ValueObjects\CreatedAt;
use Src\Category\Domain\ValueObjects\UpdatedAt;


final class CategoryEntity
{
    private ?Id $id;
    private ?CreatedAt $created_at;
    private ?UpdatedAt $updated_at;

    public function __construct( private Name $name )
    { }

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function createdAt(): CreatedAt
    {
        return $this->created_at;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updated_at;
    }

    public function setId( string|int $id ): void
    {
        $this->id = new Id($id);
    }

    public function setCreatedAt( string $date ): void
    {
        $this->created_at = new CreatedAt($date);
    }

    public function setUpdatedAt( string $date ): void
    {
        $this->updated_at = new UpdatedAt($date);
    }


    public function getPublicEntityData()
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'createdAt' => $this->created_at->value(),
            'updatedAt' => $this->updated_at->value(),
        ];
    }

}
