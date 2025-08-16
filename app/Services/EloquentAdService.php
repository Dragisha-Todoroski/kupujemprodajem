<?php

namespace App\Services;

use App\Models\Ad;
use App\Services\Contracts\AdService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentAdService implements AdService
{
    /** Fetch all ads, optionally paginated */
    public function getAll(?int $perPage = null)
    {
        $query = Ad::with(['user', 'category'])->latest();

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /** Fetch all ads by specific category, optionally paginated */
    public function getByCategory(string $categoryId, ?int $perPage = null)
    {
        $query = Ad::with(['user', 'category'])
                    ->where('category_id', $categoryId)
                    ->latest();

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /** Fetch an ad by its ID, if it exists */
    public function getById(string $id): ?Ad
    {
        return Ad::with(['user', 'category'])->findOrFail($id);
    }

    /**
     * Search ads by filters, optionally paginated
     *
     * Supported filters:
     * - title
     * - description
     * - min_price
     * - max_price
     * - location
     * - category_id
     */
    public function search(array $filters, ?int $perPage = null)
    {
        $query = Ad::with(['user', 'category'])->latest();

        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['description'])) {
            $query->where('description', 'like', '%' . $filters['description'] . '%');
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /** Create a new ad from validated data */
    public function create(array $data): Ad
    {
        return Ad::create($data);
    }

     /** Update an existing ad with validated data */
    public function update(Ad $ad, array $data): Ad
    {
        $ad->update($data);
        return $ad;
    }

    /** Delete an existing ad */
    public function delete(Ad $ad): bool
    {
        return $ad->delete();
    }
}