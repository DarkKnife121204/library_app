<?php

namespace App\Http\Swagger\Requests;
/**
 * @OA\Schema (required={"user_id", "book_id","rented_at","due_date"})
 */
class RentalStoreRequestSchema
{
    /**
     * @OA\Property (example=1)
     */
    public int $user_id;

    /**
     * @OA\Property (exmaple=1)
     */
    public int $book_id;

    /**
     * @OA\Property (exmaple="2024-11-24")
     */
    public string $rented_at;

    /**
     * @OA\Property (exmaple="2024-11-30")
     */
    public string $due_date;
}
