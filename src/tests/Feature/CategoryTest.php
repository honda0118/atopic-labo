<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Brand;
use App\Models\Category;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

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

        $response = $this->get('/categories');

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
}
