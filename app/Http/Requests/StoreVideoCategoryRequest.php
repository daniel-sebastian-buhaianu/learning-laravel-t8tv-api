<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;

class StoreVideoCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:video_category|string|max:100',
            // 'slug' => [
            //     'required',
            //     'string',
            //     'unique:video_category'
            // ]
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator)
            {
                // if (!empty($this->name) && $this->slugIsInvalid())
                // {
                //     $slug = Str::slug($this->name, '-');

                //     $validator->errors()->add(
                //         'slug',
                //         "Invalid slug. Slug value must be: $slug"
                //     );
                // }
            }
        ];
    }

    /**
     * Check if 'slug' field is invalid
     */
    private function slugIsInvalid()
    {
        // $slug = Str::slug($this->name, '-');

        // if ($this->slug !== $slug)
        // {
        //     return true;
        // }

        // return false;
    }
}
