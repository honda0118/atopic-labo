<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;
use App\Services\FloorService;

class Products
{
    /** @const decimal place */
    private const DECIMAL_PLACE = 1;

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
            $product->avg_score = $this->calcAvgScore($product->reviews->avg('pivot.score'), self::DECIMAL_PLACE);
        }
    }

    /**
     * 平均満足度を計算する
     * 
     * @access private
     * @param  int|float|null $avg_score
     * @param  int $places
     * @return int|float
     */
    private function calcAvgScore($avg_score, int $places)
    {
        if (is_null($avg_score)) {
            return 0;
        }

        return FloorService::roundDown($places, $avg_score);
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
