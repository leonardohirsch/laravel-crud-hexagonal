<?php

declare(strict_types=1);

namespace Src\Course\Domain;
use Src\Course\Domain\ValueObjects\Id;
use Src\Course\Domain\ValueObjects\Name;
use Src\Course\Domain\ValueObjects\Slug;
use Src\Course\Domain\ValueObjects\Description;
use Src\Course\Domain\ValueObjects\CreatedAt;
use Src\Course\Domain\ValueObjects\UpdatedAt;


final class CourseEntity
{
    private ?Id $id;
    private ?CreatedAt $created_at;
    private ?UpdatedAt $updated_at;

    public function __construct(
        private Name $name,
        private Slug $slug,
        private Description $description,
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

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function description(): Description
    {
        return $this->description;
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
            'slug' => $this->slug->value(),
            'description' => $this->description->value(),
            'createdAt' => $this->created_at->value(),
            'updatedAt' => $this->updated_at->value(),
        ];
    }

}
