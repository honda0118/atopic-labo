<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_switch_いいねを保存すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);

        $response = $this->actingAs($user)->post(route('likes.switch', ['product' => $product->id]));

        // Created(201)HTTPステータスコードを返すこと
        $response->assertCreated()
            // いいね件数を返すこと
            ->assertJson(['likesNumber' => 1]);

        // いいねをデータベースに保存すること
        $this->assertDatabaseHas('likes', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * @access public
     * @return void
     */
    public function test_switch_いいねを削除すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $user->likes()->attach($product->id);

        $response = $this->actingAs($user)->post(route('likes.switch', ['product' => $product->id]));

        $response->assertStatus(200)
            // いいね件数を返すこと
            ->assertJson(['likesNumber' => 0]);

        // いいねをデータベースから削除すること
        $this->assertDatabaseMissing('likes', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }
}
