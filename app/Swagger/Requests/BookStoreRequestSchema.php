<?php

namespace App\Swagger\Requests;
/**
 * @OA\Schema (required={"name", "bio","published_at"})
 */
class BookStoreRequestSchema
{
    /**
     * @OA\Property (example="name")
     */
    public string $name;

    /**
     * @OA\Property (example="bio")
     */
    public string $bio;

    /**
     * @OA\Property (example="2024-11-24")
     */
    public string $published_at;
}
