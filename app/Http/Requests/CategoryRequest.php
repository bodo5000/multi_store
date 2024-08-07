<?php

namespace App\Http\Requests;

use App\Rules\ForbiddenNames;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->route('category')) {
            return Gate::allows('categories.update');
        }
        return Gate::allows('categories.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:60', Rule::unique('categories', 'name')->ignore($this->route('category')), new ForbiddenNames(['laravel', 'php'])],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,png', 'max:1048576', 'dimensions:min_width=100,min_height:100'],
            'status' => ['in:active,archived']
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'you have same category name',
            'parent_id.integer' => 'thats not valid category'
        ];
    }
}
