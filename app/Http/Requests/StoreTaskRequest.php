<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\Task;
class StoreTaskRequest extends FormRequest
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
    // make a custom validation rule for this #TODO
    // protected $allowedStatuses = ['TODO', 'IN PROGRESS', 'DONE'];


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

     // implement rule for duplicate entry key
    public function rules()
    {

        return [
            'title'=>'required|string|max:255|unique:tasks,title',
            'description'=>'required|min:3',
            'status'=>'nullable|string|max:50|',
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
            'validator'=>$validator
        ]);
        throw new HttpResponseException($response);
    }

    
}
