<?php

declare(strict_types=1);

namespace Src\Student\Infrastructure\Repositories;

use App\Models\Student as EloquentStudentModel;
use Src\Student\Domain\StudentEntity;
use Src\Student\Domain\Contracts\StudentRepository;
use Src\Student\Domain\ValueObjects\Name;
use Src\Student\Domain\ValueObjects\Email;

class EloquentStudentRepository implements StudentRepository
{

    public function __construct( private EloquentStudentModel $model )
    { }

    private function findByCriteria( string|int $key ): ?EloquentStudentModel
    {
        return ( is_numeric($key) ) ?
                $this->model::find($key) :
                $this->model::where('email', $key)->first();
    }

    public function create( StudentEntity $Student ): void
    {

        $newStudent = $this->model;

        $data = [
            'name' => $Student->name()->value(),
            'email' => $Student->email()->value(),
        ];

        $newStudent->create( $data );
    }

    public function find( string|int $key ): ?StudentEntity
    {
        $result = $this->findByCriteria($key);

        if ( is_null($result) ) {
            return null;
        }

        $Student = new StudentEntity(
            name: new Name($result->name),
            email: new Email($result->email),
        );

        $Student->setId($result->id);
        $Student->setCreatedAt($result->created_at->__toString());
        $Student->setUpdatedAt($result->updated_at->__toString());

        return $Student;

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
        $Student = $this->findByCriteria($key);

        if ( is_null($Student) ) {
            throw new \Exception('Record does not exist');
        }

        if ( array_key_exists('email', $data) && trim( $data['email'] ) !== $Student->email )
        {
            $checkNewEmailExists = $this->findByCriteria($data['email']);

            if ( !is_null( $checkNewEmailExists ) ) {

                throw new \Exception('Another Student already exist with that email');

            }

        }

        $Student->update($data);

    }

    public function delete( string|int $key ): void
    {
        $Student = $this->findByCriteria($key);

        if ( is_null($Student) ) {
            throw new \Exception('Record does not exist');
        }

        $Student->delete();
    }
}
