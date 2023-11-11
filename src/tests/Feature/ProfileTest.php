<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $response = $this->actingAs(User::factory()->create())->get('/profile');

        $response->assertOk();
    }

    /**
     * @access public
     * @param array $request_params
     * @return void
     * @dataProvider data_update_プロフィールを更新すること
     */
    public function test_update_プロフィールを更新すること(array $request_params): void
    {
        Storage::fake('public');
        // アイコンを保存する
        $file = UploadedFile::fake()->image('test.png');
        $file_path = Storage::putFile('images/icon', $file);
        $icon = basename($file_path);
        $user = User::factory(['icon' => $icon])->create();
        Storage::assertExists('images/icon/' . $icon);

        $response = $this->actingAs($user)
            ->post(route('profile.update'), $request_params);

        // アイコンを削除すること
        Storage::assertMissing('images/icon/' . $icon);
        // アイコンを保存すること
        Storage::assertExists('images/icon/' . $request_params['icon']->hashName());
        // メッセージをセッションに保存すること
        $response->assertSessionHas('message', 'プロフィールを更新しました')
            // マイページにリダイレクトすること
            ->assertRedirect(RouteServiceProvider::HOME);
        // 評価でファイルのハッシュ名を使う
        $request_params['icon'] = $request_params['icon']->hashName();
        // データベースの会員を更新すること
        $this->assertDatabaseHas('users', $request_params);
    }

    /**
     * 「test_update_プロフィールを更新すること」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_update_プロフィールを更新すること(): array
    {
        return [
            // 境界値
            // 名前は50文字以下
            // メールアドレスは74文字以下
            // ファイルサイズ8MB以下
            // ※JPGファイルの保存も確認する
            '境界値' => [
                'request_params' => [
                    'name' => str_repeat('x', 50),
                    'email' => str_repeat('x', 64) . '@gmail.com',
                    'icon' => UploadedFile::fake()->image('test.jpg')->size(8192)
                ]
            ],
            'PNGファイル' => [
                'request_params' => [
                    'name' => str_repeat('x', 50),
                    'email' => str_repeat('x', 64) . '@gmail.com',
                    'icon' => UploadedFile::fake()->image('test.png')
                ]
            ]
        ];
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     * @dataProvider data_update_プロフィールを更新しないこと
     */
    public function test_update_プロフィールを更新しないこと(array $expected, array $request_params): void
    {
        Storage::fake('public');

        $response = $this->actingAs(User::factory()->create())
            ->post(route('profile.update'), $request_params);

        // バリデーションエラーなのでリダイレクトすること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors($expected);
    }

    /**
     * 「test_update_プロフィールを更新しないこと」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_update_プロフィールを更新しないこと(): array
    {
        return [
            '必須項目が未入力' => [
                'expected' => [
                    'name' => '名前は必ず指定してください。',
                    'email' => 'メールアドレスは必ず指定してください。'
                ],
                'request_params' => [
                    'name' => '',
                    'email' => ''
                ]
            ],
            '名前が文字列以外' => [
                'expected' => [
                    'name' => '名前は文字列を指定してください。'
                ],
                'request_params' => [
                    'name' => 1
                ]
            ],
            'メールアドレスが文字列以外' => [
                'expected' => [
                    'email' => 'メールアドレスは文字列を指定してください。'
                ],
                'request_params' => [
                    'email' => 1
                ]
            ],
            // 境界値超え
            // 名前は50文字以下
            // メールアドレスは74文字以下
            // ファイルサイズ8MB以下
            '境界値超え' => [
                'expected' => [
                    'name' => '名前は、50文字以下で指定してください。',
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                    'icon' => '8MB以下のファイルを選択してください。'
                ],
                'request_params' => [
                    'name' => str_repeat('x', 51),
                    'email' => str_repeat('x', 65) . '@gmail.com',
                    'icon' => UploadedFile::fake()->image('test.png')->size(8193)
                ]
            ],
            'RFCに準拠していないメールアドレス。＠マークの前にドットがある。' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'test.@gmail.com'
                ]
            ],
            'RFCに準拠していないメールアドレス。＠マークの後ろにドットがある。' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'test@.gmail.com'
                ]
            ],
            '不正な文字(キリル文字)のメールアドレス' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'аtest@gmail.com'
                ]
            ],
            'RFCに準拠していない文字を含むメールアドレス' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'あtest@gmail.com'
                ]
            ],
            '存在しないドメインのメールアドレス' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'test@gmail12345.com'
                ]
            ],
            '画像ファイル以外' => [
                'expected' => [
                    'icon' => 'アイコンには画像ファイルを指定してください。'
                ],
                'request_params' => [
                    'icon' => UploadedFile::fake()->image('test.txt')
                ]
            ],
            'JPEG、PNGファイル以外' => [
                'expected' => [
                    'icon' => 'アイコンにはjpeg, pngタイプのファイルを指定してください。'
                ],
                'request_params' => [
                    'icon' => UploadedFile::fake()->image('test.gif')
                ]
            ]
        ];
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     */
    public function test_update_登録済みメールアドレスの場合は、会員を更新しないこと(): void
    {
        Storage::fake('public');
        User::factory()->create(['email' => 'test@gmail.com']);

        $response = $this->actingAs(User::factory()->create())
            ->post(route('profile.update'), ['email' => 'test@gmail.com']);

        // バリデーションエラーなのでリダイレクトすること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors(['email' => 'メールアドレスは既に存在しています。']);
    }

    /**
     * @access public
     * @return void
     */
    public function test_editPassword_パスワード編集フォームを表示すること(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->get(route('profile.password.edit'));

        $response->assertStatus(200);
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     */
    public function test_updatePassword_パスワードを更新すること(): void
    {
        $user = User::factory()->create();
        $request_params = [
            'password' => '11111111',
            'password_confirmation' => '11111111',
        ];

        $response = $this->actingAs($user)
            ->patch(route('profile.password.update'), $request_params);

        // メッセージをセッションに保存すること
        $response->assertSessionHas('message', 'パスワードを更新しました')
            // マイページにリダイレクトすること
            ->assertRedirect(RouteServiceProvider::HOME);

        $user->fresh();
        // データベースのパスワードを更新すること
        $this->assertTrue(Hash::check($request_params['password'], $user->password));
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     * @dataProvider data_updatePassword_パスワードを更新しないこと
     */
    public function test_updatePassword_パスワードを更新しないこと(array $expected, array $request_params): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->patch(route('profile.password.update'), $request_params);

        // バリデーションエラーなのでリダイレクトすること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors($expected);
    }

    /**
     * 「test_updatePassword_パスワードを更新しないこと」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_updatePassword_パスワードを更新しないこと(): array
    {
        return [
            '必須項目が未入力' => [
                'expected' => [
                    'password' => 'パスワードは必ず指定してください。'
                ],
                'request_params' => [
                    'password' => ''
                ]
            ],
            '境界値超え。パスワードは8文字以上。' => [
                'expected' => [
                    'password' => 'パスワードは、8文字以上で指定してください。'
                ],
                'request_params' => [
                    'password' => str_repeat('x', 7),
                    'password_confirmation' => str_repeat('x', 7)
                ]
            ],
            'パスワードと確認パスワードが不一致' => [
                'expected' => [
                    'password' => 'パスワードと確認フィールドとが一致していません。',
                ],
                'request_params' => [
                    'password' => '11111111',
                    'password_confirmation' => '22222222'
                ]
            ]
        ];
    }

    /**
     * @access public
     * @return void
     */
    public function test_会員を削除すること(): void
    {
        Storage::fake('public');
        // 削除するアイコンを保存する
        $file = UploadedFile::fake()->image('test.jpg');
        Storage::putFile('images/icon', $file);
        Storage::assertExists('images/icon/' . $file->hashName());

        $user = User::factory()
            ->state(['icon' => $file->hashName()])
            ->create();

        $response = $this->actingAs($user)
            ->delete(route('profile.destroy'));

        // トップページにリダイレクトすること
        $response->assertRedirect('/');
        // アイコンを削除すること
        Storage::assertMissing('images/icon/' . $file->hashName());
        // 会員をデータベースから削除すること
        $this->assertNull($user->fresh());
    }
}
