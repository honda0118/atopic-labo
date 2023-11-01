<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_index_キーワード別商品一覧を表示すること(): void
    {
        $brand = Brand::factory()->state(['name' => 'brand_name'])->create();
        $category = Category::factory()->state(['name' => 'category_name'])->create();

        $product = Product::factory()
            ->state([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'user_id' => User::factory()->create()->id,
                'name' => 'product_name',
                'description' => 'product_description'
            ])
            ->create();

        $keyword = $brand->name . ' ' . $category->name . ' ' . $product->name . ' ' . $product->description;
        $response = $this->get(route('search.index', ['keyword' => $keyword]));

        $response->assertStatus(200);

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Index')
                ->where('title', $keyword . 'の商品検索結果')
                ->where('heading', $keyword)
                ->where('products.data.0.id', $product->id)
                ->where('brands.0.id', $brand->id)
                ->where('categories.0.id', $category->id)
        );
    }
}
