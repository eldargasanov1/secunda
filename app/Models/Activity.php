<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function subactivities(): HasMany
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    public function allSubactivities(): HasMany
    {
        return $this->subactivities()->with('allSubactivities');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Activity::class, 'id', 'parent_id');
    }
}
