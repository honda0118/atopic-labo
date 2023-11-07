<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_switch_お気に入りを保存すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        $response = $this->actingAs($user)->post(route('favorites.switch', ['product' => $product->id]));

        // Created(201)HTTPステータスコードを返すこと
        $response->assertCreated();

        // お気に入りをデータベースに保存すること
        $this->assertDatabaseHas('favorites', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @access public
     * @return void
     */
    public function test_switch_お気に入りを削除すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $product->favorites()->attach($user->id);

        $response = $this->actingAs($user)->post(route('favorites.switch', ['product' => $product->id]));

        $response->assertStatus(204);

        // お気に入りをデータベースから削除すること
        $this->assertDatabaseMissing('favorites', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @access public
     * @return void
     */
    public function test_index_お気に入り一覧を表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $user->favorites()->attach($product->id);

        $response = $this->actingAs($user)->get(route('favorites.index'));

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Favorite/Index')
                ->where('products.0.id', $product->id)
        );

        $response->assertStatus(200);
    }

    /**
     * @access public
     * @return void
     */
    public function test_destroy_同期通信でお気に入りを削除すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $user->favorites()->attach($product->id);
        $product = $user->favorites()->find($product->id);

        $response = $this->actingAs($user)
            ->from(route('favorites.index'))
            ->delete(route('favorites.destroy', ['favorite' => $product->pivot->id]));

        // お気に入り一覧ページにリダイレクトすること
        $response->assertStatus(302)
            ->assertRedirect(route('favorites.index'));

        // お気に入りをデータベースから削除すること
        $this->assertDatabaseMissing('favorites', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }
}
