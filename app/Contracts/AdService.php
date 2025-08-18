<?php

namespace App\Contracts;

use App\Models\Ad;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

interface AdService
{
    /** Fetch all ads, optionally paginated */
    public function getAll(?int $perPage = null) : LengthAwarePaginator;

    /** Fetch an ad by its ID */
    public function getById(string $id): Ad;

    /** Search ads by filters, optionally paginated */
    public function search(array $filters, ?int $perPage = null): LengthAwarePaginator;

    /** Create a new ad from validated data */
    public function create(array $data, ?UploadedFile $image = null): Ad;

    /** Update an existing ad with validated data */
    public function update(Ad $ad, array $data, ?UploadedFile $image = null): Ad;

    /** Delete an existing ad */
    public function delete(Ad $ad): bool;
}
