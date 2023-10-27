<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\StorageService;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\ProfileUpdatePasswordRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * 会員を更新する
     * 
     * @access public
     * @param  ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $icon = $user->icon;

        if ($request->icon) {
            $user->icon = StorageService::putFile(StorageService::ICON_DIRECTORY, $request->icon);
        }
        // データベースエラーが発生した場合は、アイコンを削除しない
        $user->save();

        if ($icon !== 'default.png' && $request->icon) {
            StorageService::delete(StorageService::ICON_DIRECTORY, $icon);
        }

        return redirect(RouteServiceProvider::HOME)
            ->with('message', 'プロフィールを更新しました');
    }

    /**
     * パスワード編集フォームを表示する
     * 
     * @access public
     * @return Response
     */
    public function editPassword(): Response
    {
        return Inertia::render('Profile/EditPassword');
    }

    /**
     * パスワードを更新する
     * 
     * @access public
     * @param  ProfileUpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(ProfileUpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect(RouteServiceProvider::HOME)
            ->with('message', 'パスワードを更新しました');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
