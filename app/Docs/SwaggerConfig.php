<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    servers: [
        new OA\Server(
            url: "http://localhost:8000/api",
            description: "Local API Server"
        ),
        new OA\Server(
            url: "https://api.example.com/api",
            description: "Production API Server"
        )
    ]
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer"
)]
#[OA\Info(
    version: '1.0.0',
    title: 'TaskApp API'
)]
class SwaggerConfig
{

}
