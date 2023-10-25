<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * @access public
     * @param array $request_params
     * @return void
     * @dataProvider data_store_会員を登録すること
     */
    public function test_store_会員を登録すること(array $request_params): void
    {
        Storage::fake('public');

        $response = $this->post('/register', $request_params);

        // 評価で使わないので削除する
        unset($request_params['password'], $request_params['password_confirmation']);
        // 評価でファイルのハッシュ名を使う
        $request_params['icon'] = $request_params['icon']->hashName();

        // アイコンをストレージに保存すること
        Storage::assertExists('images/icon/' . $request_params['icon']);
        // 会員をデータベースに保存すること
        $this->assertDatabaseHas('users', $request_params);
        // 認証すること
        $this->assertAuthenticated();
        // マイページにリダイレクトすること
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * 「test_store_アイコンありの会員を登録すること」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_store_会員を登録すること(): array
    {
        return [
            // 境界値
            // 名前は50文字以下
            // メールアドレスは74文字以下
            // パスワードは8文字以上
            // ファイルサイズ4MB以下
            // ※JPGファイルの保存も確認する
            '境界値' => [
                'request_params' => [
                    'name' => str_repeat('x', 50),
                    'email' => str_repeat('x', 64) . '@gmail.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'icon' => UploadedFile::fake()->image('test.jpg')->size(4096)
                ],
            ],
            'PNGファイルを保存すること' => [
                'request_params' => [
                    'name' => str_repeat('x', 50),
                    'email' => str_repeat('x', 64) . '@gmail.com',
                    'password' => '12345678',
                    'password_confirmation' => '12345678',
                    'icon' => UploadedFile::fake()->image('test.png')
                ],
            ],
        ];
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     * @dataProvider data_store_会員を登録しないこと
     */
    public function test_store_会員を登録しないこと(array $expected, array $request_params): void
    {
        Storage::fake('public');

        $response = $this->post('/register', $request_params);

        // バリデーションエラーになること
        $response->assertStatus(302)
            // バリデーションエラーメッセージがセッションに保存されること
            ->assertSessionHasErrors($expected);
    }

    /**
     * 「test_store_会員を登録しないこと」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_store_会員を登録しないこと(): array
    {
        return [
            '必須項目が未入力' => [
                'expected' => [
                    'name' => '名前は必ず指定してください。',
                    'email' => 'メールアドレスは必ず指定してください。',
                    'password' => 'パスワードは必ず指定してください。'
                ],
                'request_params' => [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'password_confirmation' => ''
                ],
            ],
            '名前が文字列以外' => [
                'expected' => [
                    'name' => '名前は文字列を指定してください。'
                ],
                'request_params' => [
                    'name' => 1
                ],
            ],
            'メールアドレスが文字列以外' => [
                'expected' => [
                    'email' => 'メールアドレスは文字列を指定してください。'
                ],
                'request_params' => [
                    'email' => 1
                ],
            ],
            // 境界値超え
            // 名前は50文字以下
            // メールアドレスは74文字以下
            // パスワードは8文字以上
            // ファイルサイズ4MB以下
            '境界値超え' => [
                'expected' => [
                    'name' => '名前は、50文字以下で指定してください。',
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                    'password' => 'パスワードは、8文字以上で指定してください。',
                    'icon' => '4MB以下のファイルを選択してください。'
                ],
                'request_params' => [
                    'name' => str_repeat('x', 51),
                    'email' => str_repeat('x', 65) . '@gmail.com',
                    'password' => str_repeat('x', 7),
                    'password_confirmation' => str_repeat('x', 7),
                    'icon' => UploadedFile::fake()->image('test.png')->size(4097)
                ],
            ],
            'RFCに準拠していないメールアドレス。＠マークの前にドットがある。' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'test.@gmail.com'
                ],
            ],
            'RFCに準拠していないメールアドレス。＠マークの後ろにドットがある。' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'test@.gmail.com'
                ],
            ],
            '不正な文字(キリル文字)のメールアドレス' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'аtest@gmail.com'
                ],
            ],
            'RFCに準拠していない文字を含むメールアドレス' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'あtest@gmail.com'
                ],
            ],
            '存在しないドメインのメールアドレス' => [
                'expected' => [
                    'email' => 'メールアドレスに誤りがあります。正しく指定してください。',
                ],
                'request_params' => [
                    'email' => 'test@gmail12345.com'
                ],
            ],
            'パスワードと確認パスワードが不一致' => [
                'expected' => [
                    'password' => 'パスワードと確認フィールドとが一致していません。',
                ],
                'request_params' => [
                    'password' => '11111111',
                    'password_confirmation' => '22222222'
                ],
            ],
            '画像ファイル以外は保存できない' => [
                'expected' => [
                    'icon' => 'アイコンには画像ファイルを指定してください。'
                ],
                'request_params' => [
                    'icon' => UploadedFile::fake()->image('test.txt')
                ],
            ],
            'JPEG, PNGファイル以外は保存できない' => [
                'expected' => [
                    'icon' => 'アイコンにはjpeg, pngタイプのファイルを指定してください。'
                ],
                'request_params' => [
                    'icon' => UploadedFile::fake()->image('test.txt')
                ],
            ]
        ];
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     */
    public function test_store_登録済みメールアドレスのため、会員を登録しないこと(): void
    {
        Storage::fake('public');
        // 登録済みメールアドレスを確認するテストで使用する
        User::factory()->create(['email' => 'test@gmail.com']);

        $response = $this->post('/register', ['email' => 'test@gmail.com']);

        // バリデーションエラーになること
        $response->assertStatus(302)
            // バリデーションエラーメッセージがセッションに保存されること
            ->assertSessionHasErrors(['email' => 'メールアドレスは既に存在しています。']);
    }
}
