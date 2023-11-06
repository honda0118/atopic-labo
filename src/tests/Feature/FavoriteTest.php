<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
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
}
