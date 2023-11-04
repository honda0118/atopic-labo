<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\StorageService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * 会員を保存する
     *
     * @access public
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:50'],
                'email' => ['required', 'string', 'email:strict,spoof,filter,dns', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'icon' => ['nullable', 'file', 'max:4096', 'image', 'mimes:jpeg,png']
            ],
            [
                'icon.max' => '4MB以下のファイルを選択してください。',
            ]
        );
        // アイコンが未選択の場合は「default.png」を使用する
        $icon = 'default.png';

        if ($request->icon) {
            $icon = StorageService::putFile(StorageService::ICON_DIRECTORY, $request->icon);
        }
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'icon' => $icon
            ]
        );
        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * 会員登録メニューを表示する
     * 
     * @access public
     * @return Response
     */
    public function showRegisterMenu(): Response
    {
        return Inertia::render('Auth/RegisterMenu');
    }
}
