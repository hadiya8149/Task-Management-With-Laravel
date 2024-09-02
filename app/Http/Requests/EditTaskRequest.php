<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\RequireTaskId;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditTaskRequest extends RequireTaskId
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
        # if the values are not changed then the default values must be used 
        return [
            'id'=>'required|integer|exists:tasks',
            'title'=>'required|string|max:255',
            'description'=>'required|max:1000',
            'status'=>'required|string|max:50',
            'tag'=>'required|string|max:100',
            'documents'=>'required|string',
            'deadline'=>'required|date|after_or_equal:today'
        ];
    }
    public function messages()
    {
        return [
            'id.required'=>'Task Id not given',
            'id.integer'=>'Id must be integer',
            'id.exists'=>"Task not found",
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.max' => 'The description may not be greater than 1000 characters.',
            'tag.string' => 'The tag must be a string.',
            'tag.max' => 'The tag may not be greater than 255 characters.',
            'documents.string' => 'The document file path must be string',
            'deadline.date' => 'The deadline must be a valid date.',
            'deadline.after_or_equal' => 'The deadline must be today or a future date.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();
        $response =  response()->json([
            'validation errors'=>$errors,
        ]);
        throw new HttpResponseException($response);
    }
}
