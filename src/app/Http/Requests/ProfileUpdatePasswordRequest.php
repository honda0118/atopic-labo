<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUpdatePasswordRequest extends FormRequest
{
    /**
     * ProfileController updatePasswordメソッドで使用するバリデーションルール
     *
     * @access public
     * @return array<string, array<string|Password>>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }
}
