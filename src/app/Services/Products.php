<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;
use App\Services\FloorService;

class Products
{
    /** @var LengthAwarePaginator<Product>|Collection<Product> $products */
    private $products;

    /**
     * 初期化
     *
     * @access public
     * @param LengthAwarePaginator<Product>|Collection<Product> $products
     */
    public function __construct($products)
    {
        $this->products = $products;
        $this->setAvgScore();
    }

    /**
     * 平均満足度を設定する
     * 
     * @access private
     * @return void
     */
    private function setAvgScore(): void
    {
        foreach ($this->products as $product) {
            $avg_score =  $product->reviews->avg('pivot.score');
            $product->avg_score = 0;

            if (is_numeric($avg_score)) {
                $product->avg_score = FloorService::roundDown(1, $avg_score);
            }
        }
    }

    /**
     * 商品リストを取得する
     *
     * @access public
     * @return LengthAwarePaginator<Product>|Collection<Product>
     */
    public function getProducts()
    {
        return $this->products;
    }
}
