<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_create_商品投稿フォームを表示すること(): void
    {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs(User::factory()->create())
            ->get('/products/create');

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Product/Create')
                ->where('brands.0.id', $brand->id)
                ->where('categories.0.id', $category->id)
        );

        $response->assertStatus(200);
    }

    /**
     * @access public
     * @param array $request_params
     * @return void
     * @dataProvider data_store_商品を投稿すること
     */
    public function test_store_商品を投稿すること(array $request_params): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $request_params['brand_id'] = $brand->id;
        $request_params['category_id'] = $category->id;

        $response = $this->actingAs($user)
            ->post('/products', $request_params);

        // メッセージをセッションに保存すること
        $response->assertSessionHas('message', '商品を投稿しました')
            // マイページにリダイレクトすること
            ->assertStatus(302)
            ->assertRedirect(RouteServiceProvider::HOME);

        // 商品画像を保存すること
        Storage::assertExists('images/product/' . $request_params['image1']->hashName());
        Storage::assertExists('images/product/' . $request_params['image2']->hashName());
        Storage::assertExists('images/product/' . $request_params['image3']->hashName());

        $product_image1_hashName = $request_params['image1']->hashName();
        $product_image2_hashName = $request_params['image2']->hashName();
        $product_image3_hashName = $request_params['image3']->hashName();
        $text = $request_params['text'];
        $score = $request_params['score'];
        unset($request_params['text'], $request_params['score'], $request_params['image1'], $request_params['image2'], $request_params['image3']);

        // 商品をデータベースに保存すること
        $request_params['user_id'] = $user->id;
        $this->assertDatabaseHas('products', $request_params);
        // 商品画像1をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $product_image1_hashName]);
        // 商品画像2をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $product_image2_hashName]);
        // 商品画像3をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $product_image3_hashName]);
        // クチコミをデータベースに保存すること
        $this->assertDatabaseHas('reviews', [
            'text' => $text,
            'score' => $score,
        ]);
    }

    /**
     * 「test_store_商品を投稿すること」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_store_商品を投稿すること(): array
    {
        // タイムゾーンを設定しないと、GitHub Actionsの特定の時間帯でエラーになる
        date_default_timezone_set('Asia/Tokyo');

        return [
            '境界値。クチコミ満足度1。' => [
                // 境界値
                // 商品名は50文字以下
                // 商品説明は1000文字以下
                // 税込価格は10万円以下
                // 発売日は今日以前の日付
                // 商品画像サイズ4MB以下
                // クチコミ本文は1000文字以下
                // クチコミ満足度は1以下5以下
                $request_params = [
                    'name' => str_repeat('x', 50),
                    'description' => str_repeat('x', 1000),
                    'price_including_tax' => '100000',
                    'released_at' => Carbon::now()->format('Y-m-d'),
                    'image1' => UploadedFile::fake()->image('test.jpg')->size(4096),
                    'image2' => UploadedFile::fake()->image('test.jpg')->size(4096),
                    'image3' => UploadedFile::fake()->image('test.jpg')->size(4096),
                    'text' => str_repeat('x', 1000),
                    'score' => 1,
                ],
            ],
            '境界値。クチコミ満足度5。' => [
                // 境界値
                // 商品名は50文字以下
                // 商品説明は1000文字以下
                // 税込価格は10万円以下
                // 発売日は今日以前の日付
                // 商品画像サイズ4MB以下
                // クチコミ本文は1000文字以下
                // クチコミ満足度は1以下5以下
                $request_params = [
                    'name' => str_repeat('x', 50),
                    'description' => str_repeat('x', 1000),
                    'price_including_tax' => '100000',
                    'released_at' => Carbon::now()->format('Y-m-d'),
                    'image1' => UploadedFile::fake()->image('test.jpg')->size(4096),
                    'image2' => UploadedFile::fake()->image('test.jpg')->size(4096),
                    'image3' => UploadedFile::fake()->image('test.jpg')->size(4096),
                    'text' => str_repeat('x', 1000),
                    'score' => 5,
                ],
            ],
        ];
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     * @dataProvider data_store_商品を投稿しないこと
     */
    public function test_store_商品を投稿しないこと(array $expected, array $request_params): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->post('/products', $request_params);

        // バリデーションエラーなのでリダイレクトすること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors($expected);
    }

    /**
     * 「test_store_商品を投稿しないこと」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_store_商品を投稿しないこと(): array
    {
        // タイムゾーンを設定しないと、GitHub Actionsの特定の時間帯でエラーになる
        date_default_timezone_set('Asia/Tokyo');

        return [
            '必須項目が未入力' => [
                'expected' => [
                    'brand_id' => 'ブランドは必ず指定してください。',
                    'category_id' => 'カテゴリーは必ず指定してください。',
                    'name' => '商品名は必ず指定してください。',
                    'description' => '商品説明は必ず指定してください。',
                    'price_including_tax' => '税込価格は必ず指定してください。',
                    'released_at' => '発売日は必ず指定してください。',
                    'image1' => '商品画像を選択してください。',
                ],
                'request_params' => [
                    'brand_id' => '',
                    'category_id' => '',
                    'name' => '',
                    'description' => '',
                    'price_including_tax' => '',
                    'released_at' => '',
                    'image1' => null,
                ]
            ],
            // 境界値超え
            // ブランドは存在する
            // カテゴリーは存在する
            // 商品名は50文字以下
            // 商品説明は1000文字以下
            // 税込価格は10万円以下
            // 発売日は今日以前の日付
            // 商品画像サイズ4MB以下
            // 本文は1000文字以下
            '境界値超え' => [
                'expected' => [
                    'brand_id' => '選択されたブランドは正しくありません。',
                    'category_id' => '選択されたカテゴリーは正しくありません。',
                    'name' => '商品名は、50文字以下で指定してください。',
                    'description' => '商品説明は、1000文字以下で指定してください。',
                    'price_including_tax' => '税込価格は10万円以下で指定してください。',
                    'released_at' => '発売日は今日以前の日付を指定してください。',
                    'image1' => '4MB以下の画像を選択してください。',
                    'image2' => '4MB以下の画像を選択してください。',
                    'image3' => '4MB以下の画像を選択してください。',
                ],
                'request_params' => [
                    'brand_id' => '1',
                    'category_id' => '1',
                    'name' => str_repeat('x', 51),
                    'description' => str_repeat('x', 1001),
                    'price_including_tax' => 100001,
                    'released_at' => Carbon::now()->addDay()->format('Y-m-d'),
                    'image1' => UploadedFile::fake()->image('test.png')->size(4097),
                    'image2' => UploadedFile::fake()->image('test.png')->size(4097),
                    'image3' => UploadedFile::fake()->image('test.png')->size(4097),
                ]
            ],
            // 境界値
            // 満足度は1以上5以下
            '境界値超え。満足度1より小さい。' => [
                'expected' => [
                    'score' => '満足度は、1から5の間で指定してください。',
                ],
                'request_params' => [
                    'score' => 0,
                ]
            ],
            // 境界値
            // 満足度は1以上5以下
            '境界値超え。満足度5より大きい。' => [
                'expected' => [
                    'score' => '満足度は、1から5の間で指定してください。',
                ],
                'request_params' => [
                    'score' => 6,
                ]
            ],
            '税込価格が正の整数ではない' => [
                'expected' => [
                    'price_including_tax' => '税込価格は正の整数を指定してください。'
                ],
                'request_params' => [
                    'price_including_tax' => '0011',
                ]
            ],
            '画像ファイル以外' => [
                'expected' => [
                    'image1' => '商品画像には画像ファイルを指定してください。',
                    'image2' => '商品画像には画像ファイルを指定してください。',
                    'image3' => '商品画像には画像ファイルを指定してください。',
                ],
                'request_params' => [
                    'image1' => UploadedFile::fake()->image('test.txt'),
                    'image2' => UploadedFile::fake()->image('test.txt'),
                    'image3' => UploadedFile::fake()->image('test.txt'),
                ]
            ],
            'JPEG, PNGファイル以外' => [
                'expected' => [
                    'image1' => '商品画像にはjpeg, pngタイプのファイルを指定してください。',
                    'image2' => '商品画像にはjpeg, pngタイプのファイルを指定してください。',
                    'image3' => '商品画像にはjpeg, pngタイプのファイルを指定してください。',
                ],
                'request_params' => [
                    'image1' => UploadedFile::fake()->image('test.gif'),
                    'image2' => UploadedFile::fake()->image('test.gif'),
                    'image3' => UploadedFile::fake()->image('test.gif'),
                ]
            ],
        ];
    }

    /**
     * @access public
     * @return void
     */
    public function test_store_登録済み商品名のため、商品を投稿しないこと(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $request_params['name'] = $product->name;

        $response = $this->actingAs($user)
            ->post('/products', $request_params);

        // バリデーションエラーなのでリダイレクトすること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors([
                'name' => '商品名は既に存在しています。',
            ]);
    }

    /**
     * @access public
     * @return void
     */
    public function test_index_投稿商品一覧を表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        $response = $this->actingAs($user)
            ->get('/products');

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Product/Index')
                ->where('products.0.id', $product->id)
        );

        $response->assertStatus(200);
    }
}
