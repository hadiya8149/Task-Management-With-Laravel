<?php
namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SignupRequest extends FormRequest
{
    // protected $stopOnFirstFailure = true;
    // protected $redirectRoute = 'errors';


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
            'email'=>'required|email|unique:users,email',
            'name'=>'required|string',
            'password_confirmation'=>'required',
            'password'=>['required', 'confirmed', Password::min(8),'max:11']
        ];
    }
    public function messages()
    {
        return 
        [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();

        $response =  response()->json([
            'validation errors'=>$errors
        ]);
        throw new HttpResponseException($response);
    }
    


}
