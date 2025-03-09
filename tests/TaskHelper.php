<?php

namespace Tests;

class TaskHelper
{
    public static function listResponseStructure(): array
    {
        return [
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ]
            ]
        ];
    }

    public static function oneTaskResponseStructure(): array
    {
        return [
            'data' => [
                'id',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at',
            ]
        ];
    }
}
