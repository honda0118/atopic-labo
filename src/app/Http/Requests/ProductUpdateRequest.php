<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * ProductController updateメソッドで使用するバリデーションルール
     *
     * @access public
     * @param Request $request
     * @return array<string, array<string|Rule>>
     */
    public function rules(Request $request): array
    {
        return [
            'brand_id' => ['required', 'exists:brands,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:50', Rule::unique('products')->ignore($request->route('product'))],
            'description' => ['required', 'string', 'max:1000'],
            'price_including_tax' => ['required', 'integer', 'max:100000', 'regex:/^[1-9][0-9]*$/'],
            'released_at' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'image1' => ['nullable', 'file', 'max:8192', 'image', 'mimes:jpeg,png'],
            'image2' => ['nullable', 'file', 'max:8192', 'image', 'mimes:jpeg,png'],
            'image3' => ['nullable', 'file', 'max:8192', 'image', 'mimes:jpeg,png']
        ];
    }

    /**
     * エラーメッセージ
     *
     * @access public
     * @return array
     */
    public function messages(): array
    {
        return [
            'image1.max' => '4MB以下の画像を選択してください。',
            'image2.max' => '4MB以下の画像を選択してください。',
            'image3.max' => '4MB以下の画像を選択してください。',
            'released_at.before_or_equal' => '発売日は今日以前の日付を指定してください。',
            'price_including_tax.regex' => '税込価格は正の整数を指定してください。',
            'price_including_tax.max' => '税込価格は10万円以下で指定してください。'
        ];
    }

    /**
     * 項目
     *
     * @access public
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => '商品名',
            'description' => '商品説明',
            'image1' => '商品画像',
            'image2' => '商品画像',
            'image3' => '商品画像'
        ];
    }
}
