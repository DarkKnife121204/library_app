<?php

namespace App\Http\Swagger\Requests;
/**
 * @OA\Schema (required={"name", "bio","published_at"})
 */
class BookUpdateRequestSchema
{
    /**
     * @OA\Property (example="name")
     */
    public string $name;

    /**
     * @OA\Property (exmaple="bio")
     */
    public string $bio;

    /**
     * @OA\Property (exmaple="2024-11-24")
     */
    public string $published_at;
}
