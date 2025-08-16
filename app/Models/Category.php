<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    /*
    * Method is used to ensure a category isn't the child of its own descendants (circular parenting)
    * It returns a merged array of this category's descendants' primary key values
    * This array's primary key values are considered forbidden for the `parent_id` property
    */
    public function descendantsKeys(): array
    {
        $keys = [];

        foreach ($this->children as $child) {
            $keys[] = $child->getKey(); // add child primary key value
            $keys = array_merge($keys, $child->descendantsKeys()); // recursively add grandchildren, great-grandchildren, etc.
        }

        return $keys;
    }

    /**
     * Get all descendants of this category recursively.
     *
     * This returns the category's immediate children,
     * and for each child, it also loads their children recursively.
     * The result is a nested tree structure of all descendants.
     */
    public function allDescendantsRecursive(): HasMany
    {
        return $this->children()->with('allDescendantsRecursive');
    }

    protected static function boot(): void
    {
        parent::boot();

        // Cascade delete children at the model level
        static::deleting(function ($model) {
            foreach ($model->children as $child) {
                $child->delete(); // triggers deleting event on children too
            }
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
