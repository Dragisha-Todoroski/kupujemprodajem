<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

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

    protected static function boot() {
        parent::boot();

        // Auto-assign a new UUID to primary key on model creation if it's empty
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        // Cascade delete children at the model level
        static::deleting(function ($model) {
            foreach ($model->children as $child) {
                $child->delete(); // triggers deleting event on children too
            }
        });
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
