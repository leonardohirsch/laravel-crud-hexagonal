<?php

declare(strict_types=1);

namespace Src\Document\Domain;
use Src\Document\Domain\ValueObjects\Id;
use Src\Document\Domain\ValueObjects\Name;
use Src\Document\Domain\ValueObjects\Path;
use Src\Document\Domain\ValueObjects\CreatedAt;
use Src\Document\Domain\ValueObjects\UpdatedAt;


final class DocumentEntity
{
    private ?Id $id;
    private ?CreatedAt $created_at;
    private ?UpdatedAt $updated_at;

    public function __construct(
        private Name $name,
        private Path $path,
        )
    { }

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function path(): Path
    {
        return $this->path;
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
            'path' => $this->path->value(),
            'createdAt' => $this->created_at->value(),
            'updatedAt' => $this->updated_at->value(),
        ];
    }

}
