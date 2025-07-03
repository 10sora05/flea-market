<?php

// app/Http/Requests/ItemRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'in:fashion,electronics,interior',
            'condition' => 'required|in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い',
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'description' => 'required|string|max:1000',
            'price' => 'required|integer|min:1|max:1000000',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください。',
            'categories.required' => 'カテゴリーを選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'name.required' => '商品名を入力してください。',
            'description.required' => '商品の説明を入力してください。',
            'price.required' => '販売価格を入力してください。',
        ];
    }
}
