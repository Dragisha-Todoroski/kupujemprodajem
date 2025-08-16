<?php

namespace App\Contracts;

use App\Models\Ad;
use Illuminate\Support\Collection;

interface AdService
{
    /** Fetch all ads, optionally paginated */
    public function getAll(?int $perPage = null);

    /** Fetch all ads by specific category, optionally paginated */
    public function getAllByCategory(string $categoryId, ?int $perPage = null);

    /** Fetch an ad by its ID, if it exists */
    public function getById(string $id): ?Ad;

    /** Search ads by filters, optionally paginated */
    public function search(array $filters, ?int $perPage = null);

    /** Create a new ad from validated data */
    public function create(array $data): Ad;

    /** Update an existing ad with validated data */
    public function update(Ad $ad, array $data): Ad;

    /** Delete an existing ad */
    public function delete(Ad $ad): bool;
}
