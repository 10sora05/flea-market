<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        // ログイン済みでないとアクセスさせないなどの制御を入れてもOK
        return true;
    }

    public function rules(): array
    {
        return [
            'img' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'post' => ['nullable', 'regex:/^\d{3}-\d{4}$/', 'size:8'],
            'address' => ['nullable', 'string', 'max:255'],
            'bldg' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'img.image' => '画像ファイルをアップロードしてください。',
            'img.mimes' => 'プロフィール画像はJPEGまたはPNG形式でアップロードしてください。',
            'img.max' => '画像サイズは2MB以内でお願いします。',
            'post.required' => '郵便番号を入力してください。',
            'post.regex' => '郵便番号は「123-4567」の形式で入力してください。',
            'post.size' => '郵便番号は8文字で入力してください。',
            'address.required' => '住所を入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'bldg.max' => '建物名は255文字以内で入力してください。',
        ];
    }
}
