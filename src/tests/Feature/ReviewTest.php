<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_create_クチコミ投稿フォームを表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        $response = $this->actingAs($user)
            ->get(route('reviews.create', ['product_id' => $product->id]));

        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Review/Create')
        );

        $response->assertStatus(200);
    }

    /**
     * @access public
     * @return void
     */
    public function test_create_投稿済みのクチコミがある場合は、403HTTPステータスコードを返すこと(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $user->reviews()->attach($product->id, ['score' => 5, 'text' => 'test_text']);

        $response = $this->actingAs($user)
            ->get(route('reviews.create', ['product_id' => $product->id]));

        // Forbidden(403)HTTPステータスコードを返すこと
        $response->assertForbidden();
    }

    /**
     * @access public
     * @return void
     */
    public function test_store_クチコミを投稿すること。満足度1。(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        // 境界値
        // 本文は1000文字以下
        // 満足度は1以上5以下
        $request_params = [
            'text' => str_repeat('x', 1000),
            'score' => 1,
        ];

        $response = $this->actingAs($user)
            ->post(route('reviews.store', ['product_id' => $product->id]), $request_params);

        // 商品詳細にリダイレクトすること
        $response->assertStatus(302)
            ->assertRedirect(route('products.show', ['product' => $product->id]));

        // 商品をデータベースに保存すること
        $this->assertDatabaseHas('reviews', $request_params);
    }

    /**
     * @access public
     * @return void
     */
    public function test_store_クチコミを投稿すること。満足度5。(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        // 境界値
        // 本文は1000文字以下
        // 満足度は1以上5以下
        $request_params = [
            'text' => str_repeat('x', 1000),
            'score' => 5,
        ];

        $response = $this->actingAs($user)
            ->post(route('reviews.store', ['product_id' => $product->id]), $request_params);

        // 商品詳細にリダイレクトすること
        $response->assertStatus(302)
            ->assertRedirect(route('products.show', ['product' => $product->id]));

        // 商品をデータベースに保存すること
        $this->assertDatabaseHas('reviews', $request_params);
    }

    /**
     * @access public
     * @return void
     */
    public function test_store_投稿済みのクチコミがある場合は、403HTTPステータスコードを返すこと(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $user->reviews()->attach($product->id, ['score' => 5, 'text' => 'test_text']);

        $response = $this->actingAs($user)
            ->post(route('reviews.store', ['product_id' => $product->id]));

        // Forbidden(403)HTTPステータスコードを返すこと
        $response->assertForbidden();
    }

    /**
     * @access public
     * @param array $expected
     * @param array $request_params
     * @return void
     * @dataProvider data_store_クチコミを投稿しないこと
     */
    public function test_store_クチコミを投稿しないこと(array $expected, array $request_params): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        $response = $this->actingAs($user)
            ->post(route('reviews.store', ['product_id' => $product->id]), $request_params);

        // バリデーションエラーなのでリダイレクトすること
        $response->assertStatus(302)
            // バリデーションエラーメッセージをセッションに保存すること
            ->assertSessionHasErrors($expected);
    }

    /**
     * 「test_store_クチコミを投稿しないこと」メソッドにデータを提供する
     * 
     * @access public
     * @return array
     */
    public function data_store_クチコミを投稿しないこと(): array
    {
        return [
            '必須項目が未入力' => [
                'expected' => [
                    'text' => '本文は必ず指定してください。',
                    'score' => '満足度は必ず指定してください。',
                ],
                'request_params' => [
                    'text' => '',
                    'score' => '',
                ]
            ],
            '本文が文字列以外' => [
                'expected' => [
                    'text' => '本文は文字列を指定してください。',
                ],
                'request_params' => [
                    'text' => 1,
                ]
            ],
            '本文は1000文字以下' => [
                'expected' => [
                    'text' => '本文は、1000文字以下で指定してください。',
                ],
                'request_params' => [
                    'text' => str_repeat('x', 1001),
                ]
            ],
            '満足度1より小さい' => [
                'expected' => [
                    'score' => '満足度は、1から5の間で指定してください。',
                ],
                'request_params' => [
                    'score' => 0,
                ],
            ],
            '満足度5より大きい' => [
                'expected' => [
                    'score' => '満足度は、1から5の間で指定してください。',
                ],
                'request_params' => [
                    'score' => 6,
                ],
            ],
        ];
    }
}
