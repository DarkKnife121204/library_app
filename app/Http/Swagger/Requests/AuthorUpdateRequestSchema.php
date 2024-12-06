<?php

namespace App\Http\Swagger\Requests;
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
     * @OA\Property (exmaple="bio")
     */
    public string $bio;
}
