<?php

declare(strict_types=1);

namespace Src\Student\Domain;
use Src\Student\Domain\ValueObjects\Id;
use Src\Student\Domain\ValueObjects\Name;
use Src\Student\Domain\ValueObjects\Email;
use Src\Student\Domain\ValueObjects\CreatedAt;
use Src\Student\Domain\ValueObjects\UpdatedAt;


final class StudentEntity
{
    private ?Id $id;
    private ?CreatedAt $created_at;
    private ?UpdatedAt $updated_at;

    public function __construct(
        private Name $name,
        private Email $email,
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

    public function email(): Email
    {
        return $this->email;
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
            'email' => $this->email->value(),
            'createdAt' => $this->created_at->value(),
            'updatedAt' => $this->updated_at->value(),
        ];
    }

}
