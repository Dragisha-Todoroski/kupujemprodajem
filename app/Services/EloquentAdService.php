<?php

namespace App\Services;

use App\Models\Ad;
use App\Contracts\AdService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EloquentAdService implements AdService
{
    /** Fetch all ads, optionally paginated */
    public function getAll(?int $perPage = null): LengthAwarePaginator
    {
        $query = Ad::with(['user', 'category'])->latest();

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
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
    public function search(array $filters, ?int $perPage = null): LengthAwarePaginator
    {
        $query = Ad::with(['user', 'category']);

        // ----- FILTERS -----
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

        // ----- SORTING -----
        $allowedColumns = ['title', 'price', 'condition', 'created_at'];
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        // Validates inputs
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $perPage = $perPage ?? 12; // default 12 per page
        return $query->paginate($perPage)->withQueryString();
    }

    /** Create a new ad from validated data */
    public function create(array $data, ?UploadedFile $image = null): Ad
    {
        // Attaches the current user to their new ad
        $data['user_id'] = Auth::id();

        // Handles image upload if provided
        if ($image) {
            $data['image_path'] = $image->store('ads', 'public'); // saves the uploaded image in 'storage/app/public/ads'
        }

        return Ad::create($data);
    }

     /** Update an existing ad with validated data */
    public function update(Ad $ad, array $data, ?UploadedFile $image = null): Ad
    {
        // Handles image upload if provided
        if ($image) {
            // Optionally, deletes old image if exists
            if ($ad->image_path) {
                Storage::disk('public')->delete($ad->image_path);
            }

            $data['image_path'] = $image->store('ads', 'public'); // saves the uploaded image in 'storage/app/public/ads'
        }

        $ad->update($data);

        return $ad;
    }

    /** Delete an existing ad */
    public function delete(Ad $ad): bool
    {
        return $ad->delete();
    }
}