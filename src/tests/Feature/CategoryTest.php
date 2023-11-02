<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_index_カテゴリー一覧を表示すること(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Category/Index')
                ->where('asideBrands.0.id', $brand->id)
                ->where('asideCategories.0.id', $category->id)
                ->where('categories.0.id', $category->id)
        );
    }

    /**
     * @access public
     * @return void
     */
    public function test_showProductsByCategory_カテゴリー別商品一覧を表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $brand = Brand::first();
        $category = Category::first();

        $response = $this->get(route('categories.products', ['category' => $category->id]));

        $response->assertStatus(200);

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Index')
                ->where('title', $category->name)
                ->where('heading', $category->name)
                ->where('products.data.0.id', $product->id)
                ->where('brands.0.id', $brand->id)
                ->where('categories.0.id', $category->id)
        );
    }

    /**
     * @access public
     * @return void
     */
    public function test_showProductsByCategory_カテゴリー別商品がない場合はインデックスページにリダイレクトすること(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.products', ['category' => $category->id]));

        $response->assertStatus(302)
            ->assertRedirect('/');
    }

    /**
     * @access public
     * @return void
     */
    public function test_showProductsByCategory_カテゴリー別商品閲覧数をインクリメントすること(): void
    {
        $category = Category::factory()->create();

        $this->get(route('categories.products', ['category' => $category->id]));

        $this->assertSame(1, $category->fresh()->view_count);
    }
}
