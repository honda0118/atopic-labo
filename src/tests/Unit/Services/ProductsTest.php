<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_setAvgScore_平均満足度を設定すること(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();
        $product = ProductFactory::create($user1->id);
        $user1->reviews()->attach($product->id, ['text' => '', 'score' => 3]);
        $user2->reviews()->attach($product->id, ['text' => '', 'score' => 3]);
        $user3->reviews()->attach($product->id, ['text' => '', 'score' => 4]);

        $products = new Products([$product]);

        $this->assertSame(3.3, $products->getProducts()[0]->avg_score);
    }
}
