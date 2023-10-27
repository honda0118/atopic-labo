<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * ProfileController updateメソッドで使用するバリデーションルール
     *
     * @access public
     * @return array<string, array<string|Rule>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email:strict,spoof,filter,dns', Rule::unique(User::class)->ignore($this->user()->id)],
            'icon' => ['nullable', 'file', 'max:4096', 'image', 'mimes:jpeg,png']
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
            'icon.max' => '4MB以下のファイルを選択してください。'
        ];
    }
}
