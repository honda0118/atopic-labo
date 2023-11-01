<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Brand;
use App\Models\Category;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

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

        $response = $this->get('/brands');

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
}
