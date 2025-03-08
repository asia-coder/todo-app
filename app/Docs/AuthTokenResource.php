<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "AuthTokenResource"
)]
class AuthTokenResource
{
    #[OA\Property(property: "token", type: "string", example: "1|owd1EHLShgi49ZoB2WLWbhlfLd42YaTGc0MhF8ZZc7885244")]
    public string $token;
}
