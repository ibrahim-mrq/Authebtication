<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Operation\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoryRequest extends FormRequest
{

    use BaseRequest;

    public function isCategoryExists()
    {
        $category = Category::where('name', $this->name)->first();
        if ($category) {
            return true;
        }
        return false;
    }

    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $errorMessages = [];
        foreach ($validator->messages()->all() as $test) {
            $errorMessages[] = $test;
        }
        throw new HttpResponseException(
            response()->json($this->failed(422, $errorMessages), 422)
        );
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'photo' => 'mimes:jpeg,png'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'description.required' => 'The description field is required.',
            'photo.mimes' => 'The photo type like [jpeg,png].',
        ];
    }
}