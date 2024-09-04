<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class AssignTaskRequest extends FormRequest
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
            'task_id'=>'required|integer|exists:tasks,id',
            // 'name'=>'required|string|exists:users,name'
            'user_id'=>'required|integer|exists:users,id'

    
        ];
    }
    public function messages()
    {
        return [
            'task_id.required'=>'Task id is required',
            'task_id.integer'=>'Invalid Task id',
            'task_id.exists'=>'Task not found',
            'user_id.required'=>'user id is requried',
            'user_id.string'=> 'Invalid user id. id must be of type integer',
            'user_id.exists'=>'User not found'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();
        $response =  response()->json([
            'input validation errors'=>$errors
        ]);
        throw new HttpResponseException($response);
    }
}
