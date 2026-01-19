<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('note.validation.name_required'),
            'content.required' => __('note.validation.content_required'),
            'image.image' => __('note.validation.image_type'),
            'image.max' => __('note.validation.image_size'),
            'category_ids.required' => __('note.validation.category_required'),
            'category_ids.min' => __('note.validation.category_required'),
            'category_ids.*.exists' => __('note.validation.category_invalid'),
        ];
    }
}
