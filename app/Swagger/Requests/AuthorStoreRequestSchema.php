<?php

namespace App\Swagger\Requests;
/**
 * @OA\Schema (required={"name", "bio"})
 */
class AuthorStoreRequestSchema
{
    /**
     * @OA\Property (example="name")
     */
    public string $name;

    /**
     * @OA\Property (example="bio")
     */
    public string $bio;
}
