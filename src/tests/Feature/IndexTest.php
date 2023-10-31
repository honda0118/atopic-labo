<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Factories\ProductFactory;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @access public
     * @return void
     */
    public function test_index_インデックスページを表示すること()
    {
        $user = User::factory()->create();
        $product = ProductFactory::create($user->id);
        $brand = Brand::first();
        $category = Category::first();

        $response = $this->get('/');

        $response->assertStatus(200);

        // コンポーネントにデータを渡すこと
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Index')
                ->where('isIndexPage', true)
                ->where('products.data.0.id', $product->id)
                ->where('brands.0.id', $brand->id)
                ->where('categories.0.id', $category->id)
        );
    }
}
