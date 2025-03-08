<?php

namespace App\Http\Requests\V1\Task;

use App\DTO\V1\Task\TaskListDTO;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $statusesStr = implode(',', [TaskStatus::ACTIVE->value, TaskStatus::COMPLETED->value]);

        return [
            'filter' => 'nullable|array',
            'filter.status' => 'nullable|string|in:' . $statusesStr,
            'sort_by' => 'nullable|string|in:created_at,status',
            'sort_order' => 'nullable|string|in:asc,desc',
        ];
    }

    public function payload(): TaskListDTO
    {
        return new TaskListDTO(
            filter: $this->input('filter', []),
            sortBy: $this->input('sort_by', 'created_at'),
            sortOrder: $this->input('sort_order', 'asc'),
        );
    }
}
