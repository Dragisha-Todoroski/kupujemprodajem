<?php

namespace App\Http\Requests\Traits\AdTraits;

trait AdMessagesTrait
{
    public function adMessages(): array
    {
        return [
            // `title` field
            'title.required' => 'Title is required.',
            'title.min' => 'Title must be at least 1 character.',
            'title.max' => 'Title may not exceed 100 characters.',

            // `description` field
            'description.max' => 'Description may not exceed 400 characters.',

            // `price` field
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'price.gt' => 'Price must be greater than 0.',

            // `condition` field
            'condition.required' => 'Condition is required.',
            'condition.in' => 'Chosen condition is not one of the options.',

            // `image_path` field
            'image_path.image' => 'File must be an image.',
            'image_path.mimes' => 'Image must be jpg, jpeg, or png.',
            'image_path.max' => 'Image size may not exceed 2MB.',


            // `contact_phone` field
            'contact_phone.required' => 'Contact phone is required.',
            'contact_phone.min' => 'Contact phone must be at least 1 character.',
            'contact_phone.max' => 'Contact phone may not exceed 15 characters.',

            // `location` field
            'location.required' => 'Location is required.',
            'location.min' => 'Location must be at least 1 character.',
            'location.max' => 'Location may not exceed 100 characters.',

            // `category_id` field
            'category_id.required' => 'Category is required.',
            'category_id.uuid' => 'Category ID must be in a valid format.',
            'category_id.exists' => 'Selected category does not exist.',
        ];
    }
}
