<?php

namespace App\Swagger\Requests;
/**
 * @OA\Schema (required={"name", "bio"})
 */
class AuthorUpdateRequestSchema
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
