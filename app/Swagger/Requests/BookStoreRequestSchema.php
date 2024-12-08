<?php

namespace App\Swagger\Requests;
/**
 * @OA\Schema (required={"name", "bio","published_at"})
 */
class BookStoreRequestSchema
{
    /**
     * @OA\Property (example="title")
     */
    public string $title;

    /**
     * @OA\Property (example=1)
     */
    public int $author_id;

    /**
     * @OA\Property (example="2024-11-24")
     */
    public string $published_at;
}
