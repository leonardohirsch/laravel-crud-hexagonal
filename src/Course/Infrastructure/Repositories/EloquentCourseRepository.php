<?php

declare(strict_types=1);

namespace Src\Course\Infrastructure\Repositories;

use App\Models\Course as EloquentCourseModel;
use Src\Course\Domain\CourseEntity;
use Src\Course\Domain\Contracts\CourseRepository;
use Src\Course\Domain\ValueObjects\Name;
use Src\Course\Domain\ValueObjects\Slug;
use Src\Course\Domain\ValueObjects\Description;

class EloquentCourseRepository implements CourseRepository
{

    public function __construct( private EloquentCourseModel $model )
    { }

    private function findByCriteria( string|int $key ): ?EloquentCourseModel
    {
        return ( is_numeric($key) ) ?
                $this->model::find($key) :
                $this->model::where('slug', $key)->first();
    }

    public function create( CourseEntity $course ): void
    {
        $newCourse = $this->model;

        $data = [
            'name' => $course->name()->value(),
            'slug' => $course->slug()->value(),
            'description' => $course->description()->value(),
        ];

        $newCourse->create( $data );
    }

    public function find( string|int $key ): ?CourseEntity
    {
        $result = $this->findByCriteria($key);

        if ( is_null($result) ) {
            return null;
        }

        $course = new CourseEntity(
            name: new Name($result->name),
            slug: new Slug($result->slug),
            description: new Description($result->description),
        );

        $course->setId($result->id);
        $course->setCreatedAt($result->created_at->__toString());
        $course->setUpdatedAt($result->updated_at->__toString());

        return $course;

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
        $course = $this->findByCriteria($key);

        if ( is_null($course) ) {
            throw new \Exception('Record does not exist');
        }

        if ( array_key_exists('name', $data) && trim( $data['name'] ) !== $course->name )
        {
            $checkNewNameExists = $this->findByCriteria($data['slug']);

            if ( !is_null( $checkNewNameExists ) ) {

                throw new \Exception('Another course already exist with that name and slug');

            }

        }

        $course->update($data);

    }

    public function delete( string|int $key ): void
    {
        $course = $this->findByCriteria($key);

        if ( is_null($course) ) {
            throw new \Exception('Record does not exist');
        }

        $course->delete();
    }

    public function attachCourseable( string|int $id, string $courseable_type, array $courseable_ids ): void
    {
        $course = $this->model::findOrFail($id);

        foreach ($courseable_ids as $courseable_id) {

            $course->$courseable_type()->attach($courseable_id);

        }
    }


    public function detachCourseable( string|int $id, string $courseable_type, array $courseable_ids ): void
    {
        $course = $this->model::findOrFail($id);

        foreach ($courseable_ids as $courseable_id) {

            $course->$courseable_type()->detach($courseable_id);

        }
    }
}
