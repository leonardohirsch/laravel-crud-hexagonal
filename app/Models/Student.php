<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email'
    ];

    public function courses(): MorphToMany
    {
        return $this->morphToMany(Course::class, 'courseable');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->courses()->detach();
        });
    }

}
