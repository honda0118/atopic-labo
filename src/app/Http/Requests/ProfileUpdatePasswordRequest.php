<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class ProfileUpdatePasswordRequest extends FormRequest
{
    /**
     * ProfileController updatePasswordメソッドで使用するバリデーションルール
     *
     * @access public
     * @return array<string, array<string|Rules>>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }
}
