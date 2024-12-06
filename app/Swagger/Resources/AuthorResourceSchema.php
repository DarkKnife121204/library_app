<?php

namespace App\Swagger\Resources;
/**
 * @OA\Schema (),
 */
class AuthorResourceSchema
{
    /**
     * @OA\Property (example=1),
     */
    public int $id;

    /**
     * @OA\Property (example="name"),
     */
    public string $name;

    /**
     * @OA\Property (example="bio"),
     */

    public string $bio;

    /**
     * @OA\Property (example="2024-11-24T14:38:49.000000Z"),
     */
    public string $created_at;

    /**
     * @OA\Property (example="2024-11-24T14:38:49.000000Z"),
     */
    public string $updated_at;

}
