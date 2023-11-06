<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class RankingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_index_クチコミランキングを表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $product->reviews()->attach($user->id, [
            'text' => 'test_text',
            'score' => 1,
        ]);
        $brand = Brand::first();
        $category = Category::first();

        $response = $this->get(route('ranking.index'));

        $response->assertStatus(200);

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Ranking/Index')
                ->where('title', 'クチコミランキング')
                ->where('heading', 'クチコミランキング')
                ->where('products.0.id', $product->id)
                ->where('brands.0.id', $brand->id)
                ->where('categories.0.id', $category->id)
        );
    }

    /**
     * @access public
     * @return void
     */
    public function test_index_クチコミ商品がない場合はインデックスページにリダイレクトすること(): void
    {
        $response = $this->get(route('ranking.index'));

        $response->assertStatus(302)
            ->assertRedirect('/');
    }
}
