<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'category_name'=>'required|unique:categories',
            'category_image'=>'required',
            'category_image'=>'image',
            'category_image'=>'file|max:512',
        ];
    }
    public function messages()
    {
        return [
            'category_name.required'=>'Oi Mia Field Khali Ken?',
            'category_name.unique'=>'Ek Nam Kotobar Dibi?',
            'category_image.required'=>'Image De Beta!',
        ];
    }
}
