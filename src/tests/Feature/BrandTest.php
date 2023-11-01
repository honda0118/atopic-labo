<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_index_ブランド一覧を表示すること(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $response = $this->get(route('brands.index'));

        $response->assertStatus(200);

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Brand/Index')
                ->where('asideBrands.0.id', $brand->id)
                ->where('asideCategories.0.id', $category->id)
                ->where('brands.0.id', $brand->id)
        );
    }

    /**
     * @access public
     * @return void
     */
    public function test_showProductsPerBrand_ブランド別商品一覧を表示すること(): void
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $brand = Brand::first();
        $category = Category::first();

        $response = $this->get(route('brands.products', ['brand' => $brand->id]));

        $response->assertStatus(200);

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Index')
                ->where('title', $brand->name)
                ->where('heading', $brand->name)
                ->where('products.data.0.id', $product->id)
                ->where('brands.0.id', $brand->id)
                ->where('categories.0.id', $category->id)
        );
    }

    /**
     * @access public
     * @return void
     */
    public function test_showProductsPerBrand_ブランド別商品がない場合はインデックスページにリダイレクトすること(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->get(route('brands.products', ['brand' => $brand->id]));

        $response->assertStatus(302)
            ->assertRedirect('/');
    }

    /**
     * @access public
     * @return void
     */
    public function test_showProductsByBrand_ブランド別商品閲覧数をインクリメントすること(): void
    {
        $brand = Brand::factory()->create();

        $this->get(route('brands.products', ['brand' => $brand->id]));

        $this->assertSame(1, $brand->fresh()->view_count);
    }
}
