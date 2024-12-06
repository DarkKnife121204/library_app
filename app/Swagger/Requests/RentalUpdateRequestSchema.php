<?php

namespace App\Swagger\Requests;
/**
 * @OA\Schema (required={"return_at"})
 */
class RentalUpdateRequestSchema
{
    /**
     * @OA\Property (example="null")
     */
    public string $return_at;
}
