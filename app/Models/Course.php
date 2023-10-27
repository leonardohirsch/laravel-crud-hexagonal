<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function students(): MorphToMany
    {
        return $this->morphedByMany(Student::class, 'courseable');
    }

    public function categories(): MorphToMany
    {
        return $this->morphedByMany(Category::class, 'courseable');
    }

    public function documents(): MorphToMany
    {
        return $this->morphedByMany(Document::class, 'courseable');
    }

}
