<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>'required|string|max:255',
            'description'=>'required|text',
            'status'=>'nullable|string|max:255|in:TDDO,IN PROGRESS,DONE',
            'tag'=>'nullable|max:255',
            'documents'=>'nullable|string',
            'deadline'=>'nullable|date|after_or_equal:today'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 1000 characters.',
            'status.in' => 'The selected status is invalid. Valid statuses are: TODO, IN_PROGRESS, DONE.',
            'tag.string' => 'The tag must be a string.',
            'tag.max' => 'The tag may not be greater than 255 characters.',
            'documents.string' => 'The document file path must be string',
            'deadline.date' => 'The deadline must be a valid date.',
            'deadline.after_or_equal' => 'The deadline must be today or a future date.',
        ];
    }
}
