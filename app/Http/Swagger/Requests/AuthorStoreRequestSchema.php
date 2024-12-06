<?php

namespace App\Http\Swagger\Requests;
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
     * @OA\Property (exmaple="bio")
     */
    public string $bio;
}
