<?php

namespace Tests\Factories;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductFactory
{
    /**
     * 商品を生成する
     *
     * @access private
     * @param int $user_id
     * @param string $product_name
     * @return Product
     */
    public static function create(int $user_id, string $product_name = 'product_name'): Product
    {
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();

        return Product::factory()
            ->state([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'user_id' => $user_id,
                'name' => $product_name
            ])
            ->create();
    }
}
