<?php

namespace App\Http\Requests\V1\Task;

use App\DTO\V1\Task\TaskCreateDTO;
use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function payload(): TaskCreateDTO
    {
        return new TaskCreateDTO(
            title: $this->input('title'),
            description: $this->input('description'),
            userId: $this->user()->id,
        );
    }
}
