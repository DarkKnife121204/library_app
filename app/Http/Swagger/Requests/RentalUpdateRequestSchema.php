<?php

namespace App\Http\Swagger\Requests;
/**
 * @OA\Schema (required={"return_at"})
 */
class RentalUpdateRequestSchema
{
    /**
     * @OA\Property (exmaple="null")
     */
    public string $return_at;
}
