<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RequireTaskId extends FormRequest
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
            'id'=>'required|integer|exists:tasks'
        ];
    }
    public function messages()
    {
        return [
            'id.required'=>'Task Id not given',
            'id.integer'=>'Id must be integer',
            'id.exists'=>"Task not found"
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
