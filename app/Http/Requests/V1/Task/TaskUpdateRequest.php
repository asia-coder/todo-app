<?php

namespace App\Http\Requests\V1\Task;

use App\DTO\V1\Task\TaskUpdateDTO;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => "required|string|in:" . $statusesStr,
        ];
    }

    public function payload(): TaskUpdateDTO
    {
        return new TaskUpdateDTO(
            id: $this->route('taskId'),
            title: $this->input('title'),
            description: $this->input('description'),
            status: $this->input('status'),
            userId: $this->user()->id,
        );
    }
}
