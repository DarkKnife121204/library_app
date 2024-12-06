<?php

namespace App\Swagger\Resources;
/**
 * @OA\Schema (),
 */
class BookResourceSchema
{
    /**
     * @OA\Property (example=1),
     */
    public int $id;

    /**
     * @OA\Property (example="title"),
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

    /**
     * @OA\Property (example="2024-11-24T14:38:49.000000Z")
     */
    public string $created_at;

    /**
     * @OA\Property (example="2024-11-24T14:38:49.000000Z")
     */
    public string $updated_at;

}
