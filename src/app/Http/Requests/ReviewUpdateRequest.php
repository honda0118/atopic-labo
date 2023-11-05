<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewUpdateRequest extends FormRequest
{
    /**
     * ReviewController updateメソッドで使用するバリデーションルール
     *
     * @access public
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:1000'],
            'score' => ['required', 'integer', 'between:1,5'],
        ];
    }
}
