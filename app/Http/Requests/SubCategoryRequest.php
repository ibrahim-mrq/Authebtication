<?php

namespace App\Http\Requests;

use App\Models\SubCategory;
use App\Models\Category;
use App\Operation\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SubCategoryRequest extends FormRequest
{
    use BaseRequest;

    public function isSubCategoryExists()
    {
        $subCategory = SubCategory::where('name', $this->name)->first();
        if ($subCategory) {
            return true;
        }
        return false;
    }


    public function getCategory()
    {
        $category = Category::where('id', $this->parent_id)->first();
        return $category;
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
            'parent_id' => 'required',
            //'photo' => 'mimes:jpeg,png'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'description.required' => 'The description field is required.',
            'parent_id.required' => 'The parent id field is required.',
            //'photo.mimes' => 'The photo type like [jpeg,png].',
        ];
    }
}
