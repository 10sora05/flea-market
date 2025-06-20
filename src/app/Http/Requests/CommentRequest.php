<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ユーザー認可をコントローラで制御する場合は true にする
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'コメントは必須です。',
            'content.max' => 'コメントは255文字以内で入力してください。',
        ];
    }
}
