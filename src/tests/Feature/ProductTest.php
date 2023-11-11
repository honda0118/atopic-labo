<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Providers\RouteServiceProvider;
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
            ->get(route('products.create'));

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
     * @param array $request_image_params
     * @param array $request_review_params
     * @return void
     * @dataProvider data_store_商品を投稿すること
     */
    public function test_store_商品を投稿すること(array $request_params, array $request_image_params, array $request_review_params): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $request_params['brand_id'] = $brand->id;
        $request_params['category_id'] = $category->id;
        $marged_request_params = array_merge($request_params, $request_image_params, $request_review_params);

        $response = $this->actingAs($user)
            ->post(route('products.store'), $marged_request_params);

        // メッセージをセッションに保存すること
        $response->assertSessionHas('message', '商品を投稿しました')
            // マイページにリダイレクトすること
            ->assertStatus(302)
            ->assertRedirect(RouteServiceProvider::HOME);

        // 商品画像を保存すること
        Storage::assertExists('images/product/' . $request_image_params['image1']->hashName());
        Storage::assertExists('images/product/' . $request_image_params['image2']->hashName());
        Storage::assertExists('images/product/' . $request_image_params['image3']->hashName());

        // 商品をデータベースに保存すること
        $request_params['user_id'] = $user->id;
        $this->assertDatabaseHas('products', $request_params);
        // 商品画像1をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $request_image_params['image1']->hashName()]);
        // 商品画像2をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $request_image_params['image2']->hashName()]);
        // 商品画像3をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $request_image_params['image3']->hashName()]);
        // クチコミをデータベースに保存すること
        $this->assertDatabaseHas('reviews', [
            'text' => $request_review_params['text'],
            'score' => $request_review_params['score'],
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
        return [
            '境界値。クチコミ満足度1。' => [
                // 境界値
                // 商品名は50文字以下
                // 商品説明は1000文字以下
                // 税込価格は10万円以下
                // 購入サイトは1500文字以下
                // 商品画像サイズ8MB以下
                // クチコミ本文は1000文字以下
                // クチコミ満足度は1以下5以下
                $request_params = [
                    'name' => str_repeat('x', 50),
                    'description' => str_repeat('x', 1000),
                    'price_including_tax' => '100000',
                    'purchase_site' => 'https://' . str_repeat('x', 1492),
                ],
                $request_image_params = [
                    'image1' => UploadedFile::fake()->image('test.jpg')->size(8192),
                    'image2' => UploadedFile::fake()->image('test.jpg')->size(8192),
                    'image3' => UploadedFile::fake()->image('test.jpg')->size(8192),
                ],
                $request_review_params = [
                    'text' => str_repeat('x', 1000),
                    'score' => 1,
                ],
            ],
            '境界値。クチコミ満足度5。' => [
                // 境界値
                // 商品名は50文字以下
                // 商品説明は1000文字以下
                // 税込価格は10万円以下
                // 購入サイトは1500文字以下
                // 商品画像サイズ8MB以下
                // クチコミ本文は1000文字以下
                // クチコミ満足度は1以下5以下
                $request_params = [
                    'name' => str_repeat('x', 50),
                    'description' => str_repeat('x', 1000),
                    'price_including_tax' => '100000',
                    'purchase_site' => 'https://' . str_repeat('x', 1492),
                ],
                $request_image_params = [
                    'image1' => UploadedFile::fake()->image('test.jpg')->size(8192),
                    'image2' => UploadedFile::fake()->image('test.jpg')->size(8192),
                    'image3' => UploadedFile::fake()->image('test.jpg')->size(8192),
                ],
                $request_review_params = [
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
            ->post(route('products.store'), $request_params);

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
                    'purchase_site' => '購入サイトは必ず指定してください。',
                    'image1' => '商品画像を選択してください。',
                ],
                'request_params' => [
                    'brand_id' => '',
                    'category_id' => '',
                    'name' => '',
                    'description' => '',
                    'price_including_tax' => '',
                    'purchase_site' => '',
                    'image1' => null,
                ]
            ],
            // 境界値超え
            // ブランドは存在する
            // カテゴリーは存在する
            // 商品名は50文字以下
            // 商品説明は1000文字以下
            // 税込価格は10万円以下
            // 購入サイトは1500文字以下
            // 商品画像サイズ8MB以下
            // 本文は1000文字以下
            '境界値超え' => [
                'expected' => [
                    'brand_id' => '選択されたブランドは正しくありません。',
                    'category_id' => '選択されたカテゴリーは正しくありません。',
                    'name' => '商品名は、50文字以下で指定してください。',
                    'description' => '商品説明は、1000文字以下で指定してください。',
                    'price_including_tax' => '税込価格は10万円以下で指定してください。',
                    'purchase_site' => '購入サイトは、1500文字以下で指定してください。',
                    'image1' => '8MB以下の画像を選択してください。',
                    'image2' => '8MB以下の画像を選択してください。',
                    'image3' => '8MB以下の画像を選択してください。',
                ],
                'request_params' => [
                    'brand_id' => '1',
                    'category_id' => '1',
                    'name' => str_repeat('x', 51),
                    'description' => str_repeat('x', 1001),
                    'price_including_tax' => 100001,
                    'purchase_site' => 'https://' . str_repeat('x', 1493),
                    'image1' => UploadedFile::fake()->image('test.png')->size(8193),
                    'image2' => UploadedFile::fake()->image('test.png')->size(8193),
                    'image3' => UploadedFile::fake()->image('test.png')->size(8193),
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
            '購入サイトがURL形式以外' => [
                'expected' => [
                    'purchase_site' => '購入サイトに正しい形式を指定してください。'
                ],
                'request_params' => [
                    'purchase_site' => 'ttp://test.com/test'
                ],
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
    public function test_store_登録済み商品名の場合は、商品を投稿しないこと(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $request_params['name'] = $product->name;

        $response = $this->actingAs($user)
            ->post(route('products.store'), $request_params);

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
            ->get(route('products.index'));

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Product/Index')
                ->where('products.0.id', $product->id)
        );

        $response->assertStatus(200);
    }

    /**
     * @access public
     * @return void
     */
    public function test_edit_商品編集フォームを表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $brand = Brand::first();
        $category = Category::first();

        $response = $this->actingAs($user)
            ->get(route('products.edit', ['product' => $product->id]));

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Product/Edit')
                ->where('brands.0.id', $brand->id)
                ->where('categories.0.id', $category->id)
                ->where('product.id', $product->id)
        );

        $response->assertStatus(200);
    }

    /**
     * @access public
     * @return void
     */
    public function test_edit_アクセス権限がない場合は、商品編集フォームを表示しないこと(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        // 商品にアクセス権限がない会員
        $other_user = User::factory()->create();

        $response = $this->actingAs($other_user)
            ->get(route('products.edit', ['product' => $product->id]));

        // Forbidden(403)HTTPステータスコードを返すこと
        $response->assertForbidden();
    }

    /**
     * @access public
     * @return void
     */
    public function test_update_アクセス権限がない場合は、商品を更新しないこと(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        // 商品にアクセス権限がない会員
        $other_user = User::factory()->create();

        $response = $this->actingAs($other_user)
            ->post(route('products.update', ['product' => $product->id]));

        // Forbidden(403)HTTPステータスコードを返すこと
        $response->assertForbidden();
    }

    /**
     * @access public
     * @return void
     */
    public function test_update_商品を更新すること(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        // 削除する商品画像を保存する
        $image1 = UploadedFile::fake()->image('test.jpg');
        $image2 = UploadedFile::fake()->image('test.jpg');
        $image3 = UploadedFile::fake()->image('test.jpg');
        Storage::putFile('images/product', $image1);
        Storage::putFile('images/product', $image2);
        Storage::putFile('images/product', $image3);

        // 商品画像が保存されているか確認する
        Storage::assertExists('images/product/' . $image1->hashName());
        Storage::assertExists('images/product/' . $image2->hashName());
        Storage::assertExists('images/product/' . $image3->hashName());

        $product->productImages()->createMany([
            ['image' => $image1->hashName()],
            ['image' => $image2->hashName()],
            ['image' => $image3->hashName()]
        ]);

        // 境界値
        // 商品名は50文字以下
        // 商品説明は1000文字以下
        // 税込価格は10万円以下
        // 購入サイトは1500文字以下
        // 商品画像サイズ8MB以下
        $request_params = [
            'brand_id' => $product->brand_id,
            'category_id' => $product->category_id,
            'name' => str_repeat('x', 50),
            'description' => str_repeat('x', 1000),
            'price_including_tax' => '100000',
            'purchase_site' => 'https://' . str_repeat('x', 1492),
        ];
        $request_image_params = [
            'image1' => UploadedFile::fake()->image('test.jpg')->size(8192),
            'image2' => UploadedFile::fake()->image('test.jpg')->size(8192),
            'image3' => UploadedFile::fake()->image('test.jpg')->size(8192)
        ];
        $marged_request_params = array_merge($request_params, $request_image_params);

        $response = $this->actingAs($user)
            ->post(route('products.update', ['product' => $product->id]), $marged_request_params);

        // バリデーションエラーにならないこと
        $response->assertSessionHasNoErrors()
            // マイページにリダイレクトすること
            ->assertStatus(302)
            ->assertRedirect(RouteServiceProvider::HOME);

        // 商品画像を削除すること
        Storage::assertMissing('images/product/' . $image1->hashName());
        Storage::assertMissing('images/product/' . $image2->hashName());
        Storage::assertMissing('images/product/' . $image3->hashName());

        // 商品画像1をデータベースから削除すること
        $this->assertDatabaseMissing('product_images', ['image' => $image1->hashName()]);
        // 商品画像2をデータベースから削除すること
        $this->assertDatabaseMissing('product_images', ['image' => $image2->hashName()]);
        // 商品画像3をデータベースから削除すること
        $this->assertDatabaseMissing('product_images', ['image' => $image3->hashName()]);

        // 商品画像を保存すること
        Storage::assertExists('images/product/' . $request_image_params['image1']->hashName());
        Storage::assertExists('images/product/' . $request_image_params['image2']->hashName());
        Storage::assertExists('images/product/' . $request_image_params['image3']->hashName());

        // データベースの商品を更新すること
        $this->assertDatabaseHas('products', $request_params);
        // 商品画像1をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $request_image_params['image1']->hashName()]);
        // 商品画像2をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $request_image_params['image2']->hashName()]);
        // 商品画像3をデータベースに保存すること
        $this->assertDatabaseHas('product_images', ['image' => $request_image_params['image3']->hashName()]);
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     * @dataProvider data_update_商品を更新しないこと
     */
    public function test_update_商品を更新しないこと(array $expected, array $request_params): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        $response = $this->actingAs($user)
            ->post(route('products.update', ['product' => $product->id]), $request_params);

        // バリデーションエラーになること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors($expected);
    }

    /**
     * 「test_update_商品を更新しないこと」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_update_商品を更新しないこと(): array
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
                    'purchase_site' => '購入サイトは必ず指定してください。'
                ],
                'request_params' => [
                    'brand_id' => '',
                    'category_id' => '',
                    'name' => '',
                    'description' => '',
                    'price_including_tax' => '',
                    'purchase_site' => ''
                ],
            ],
            // 境界値
            // ブランドは存在する
            // カテゴリーは存在する
            // 商品名は50文字以下
            // 商品説明は1000文字以下
            // 税込価格は10万円以下
            // 購入サイトは1500文字以下
            // 商品画像サイズ8MB以下
            '境界値超え' => [
                'expected' => [
                    'brand_id' => '選択されたブランドは正しくありません。',
                    'category_id' => '選択されたカテゴリーは正しくありません。',
                    'name' => '商品名は、50文字以下で指定してください。',
                    'description' => '商品説明は、1000文字以下で指定してください。',
                    'price_including_tax' => '税込価格は10万円以下で指定してください。',
                    'purchase_site' => '購入サイトは、1500文字以下で指定してください。',
                    'image1' => '8MB以下の画像を選択してください。',
                    'image2' => '8MB以下の画像を選択してください。',
                    'image3' => '8MB以下の画像を選択してください。',
                ],
                'request_params' => [
                    'brand_id' => '100',
                    'category_id' => '100',
                    'name' => str_repeat('x', 51),
                    'description' => str_repeat('x', 1001),
                    'price_including_tax' => 100001,
                    'purchase_site' => 'https://' . str_repeat('x', 1493),
                    'image1' => UploadedFile::fake()->image('test.png')->size(8193),
                    'image2' => UploadedFile::fake()->image('test.png')->size(8193),
                    'image3' => UploadedFile::fake()->image('test.png')->size(8193),
                ],
            ],
            '商品名が文字列以外' => [
                'expected' => [
                    'name' => '商品名は文字列を指定してください。'
                ],
                'request_params' => [
                    'name' => 1
                ],
            ],
            '商品説明が文字列以外' => [
                'expected' => [
                    'description' => '商品説明は文字列を指定してください。'
                ],
                'request_params' => [
                    'description' => 1
                ],
            ],
            '購入サイトがURL形式以外' => [
                'expected' => [
                    'purchase_site' => '購入サイトに正しい形式を指定してください。'
                ],
                'request_params' => [
                    'purchase_site' => 'ttp://test.com/test'
                ],
            ],
            '税込価格が正の整数以外' => [
                'expected' => [
                    'price_including_tax' => '税込価格は正の整数を指定してください。'
                ],
                'request_params' => [
                    'price_including_tax' => '0011',
                ],
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
                ],
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
                ],
            ],
        ];
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     */
    public function test_update_登録済み商品名の場合は、商品を更新しないこと(): void
    {
        $user = User::factory()->create();
        ProductFactory::create($user->id);
        $product = ProductFactory::create($user->id, 'product_name2');

        $response = $this->actingAs($user)
            ->post(route('products.update', ['product' => $product->id]), ['name' => 'product_name']);

        // バリデーションエラーになること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors(['name' => '商品名は既に存在しています。']);
    }

    /**
     * @access public
     * @return void
     */
    public function test_destroy_アクセス権限がないので商品を削除しないこと(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        // 商品にアクセス権限がない会員
        $other_user = User::factory()->create();

        $response = $this->actingAs($other_user)
            ->delete(route('products.destroy', ['product' => $product->id]));

        // Forbidden(403)HTTPステータスコードを返すこと
        $response->assertForbidden();
    }

    /**
     * @access public
     * @return void
     */
    public function test_destroy_商品を削除すること(): void
    {
        Storage::fake('public');

        // 削除する商品画像を保存する
        $image1 = UploadedFile::fake()->image('test.png');
        $image2 = UploadedFile::fake()->image('test.png');
        $image3 = UploadedFile::fake()->image('test.png');
        Storage::putFile('images/product', $image1);
        Storage::putFile('images/product', $image2);
        Storage::putFile('images/product', $image3);

        // 商品画像が保存されているか確認する
        Storage::assertExists('images/product/' . $image1->hashName());
        Storage::assertExists('images/product/' . $image2->hashName());
        Storage::assertExists('images/product/' . $image3->hashName());

        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $product->productImages()->createMany([
            ['image' => $image1->hashName()],
            ['image' => $image2->hashName()],
            ['image' => $image3->hashName()],
        ]);

        $response = $this->actingAs($user)
            ->from(route('products.index'))
            ->delete(route('products.destroy', ['product' => $product->id]));

        // マイページにリダイレクトすること
        $response->assertStatus(302)
            ->assertRedirect(route('products.index'));

        // 商品画像を削除すること
        Storage::assertMissing('images/product/' . $image1->hashName());
        Storage::assertMissing('images/product/' . $image2->hashName());
        Storage::assertMissing('images/product/' . $image3->hashName());

        // 商品をデータベースから削除すること
        $this->assertNull($product->fresh());
        // 商品画像1をデータベースから削除すること
        $this->assertDatabaseMissing('product_images', ['image' => $image1->hashName()]);
        // 商品画像2をデータベースから削除すること
        $this->assertDatabaseMissing('product_images', ['image' => $image2->hashName()]);
        // 商品画像3をデータベースから削除すること
        $this->assertDatabaseMissing('product_images', ['image' => $image3->hashName()]);
    }

    /**
     * @access public
     * @return void
     */
    public function test_show_商品詳細を表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $product->likes()->attach($user->id);
        $product->favorites()->attach($user->id);
        $product->reviews()->attach($user->id, ['text' => 'test_text', 'score' => 5]);

        $response = $this->actingAs($user)
            ->get(route('products.show', ['product' => $product->id]));

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Product/Show')
                ->where('product.id', $product->id)
                ->where('hasRegisterdLike', true)
                ->where('hasRegisterdFavorite', true)
                ->where('hasRegisterdReview', true)
                ->where('likesNumber', 1)
        );

        $response->assertStatus(200);
    }
}
